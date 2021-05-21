<?php

namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Exceptions\BimerApiException;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param string $endpoint
     */
    public function __construct(string $endpoint)
    {
        $this->client = new Client();
        $this->endpoint = $endpoint;
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    private function checkAuth(): void
    {
        if (!$this->client->getToken()) {
            $this->auth();
        }
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    private function auth(): void
    {
        $credentials = $this->client->getCredentials();

        $random = rand(1, 9999);

        $form_params = array_merge($credentials, [
            'grant_type' => 'password',
            'nonce' => $random,
            'password' => md5($credentials['username'] . $random . $credentials['password'])
        ]);

        $params = [
            'form_params' => $form_params
        ];

        $response = $this->post('/oauth/token', $params);

        $token = $response->access_token ?? null;

        if (is_null($token)) {
            throw new BimerRequestException("Unable to authenticate");
        }

        $this->client->setToken($token);
    }

    /**
     * @param string $endpoint
     */
    private function setFullEndpoint(string &$endpoint = ''): void
    {
        $endpoint = $this->endpoint . '/' . $endpoint;
    }

    /**
     * @param array $options
     */
    private function setAuthHeaders(array &$options = []): void
    {
        $options = array_merge($options, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->client->getToken()
            ]
        ]);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws BimerApiException
     * @throws BimerParameterException
     * @throws BimerRequestException
     */
    public function request(string $method, string $endpoint = '', array $options = [])
    {
        if ($endpoint != '/oauth/token') {
            $this->checkAuth();
            $this->setFullEndpoint($endpoint);
            $this->setAuthHeaders($options);
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (RequestException $e) {
            if (!$e->hasResponse()) {
                throw new BimerRequestException($e->getMessage());
            }

            $response = $e->getResponse();
        } catch (ConnectException $e) { // GuzzleHttp >= v7.x
            throw new BimerRequestException($e->getMessage());
        }

        return $this->response($response);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws BimerApiException
     * @throws BimerRequestException
     */
    public function response(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        $data = json_decode($content);

        $this->checkForErrors($response, $data);

        return $data;
    }

    /**
     * @param ResponseInterface $response
     * @param \stdClass|null $data
     * @throws BimerApiException
     * @throws BimerRequestException
     */
    private function checkForErrors(ResponseInterface $response, \stdClass $data = null): void
    {
        $code = $response->getStatusCode();
        $statusClass = (int)($code / 100);

        if ($statusClass === 4 || $statusClass === 5) {
            if ($this->ignoreException($data)) return;
            $this->checkForApiException($data);
            $this->checkForRequestException($response, $data);
        }
    }

    /*
        Since Bimer API always responds with a 400 HTTP for all the following,
        we then need to trust on its "ErrorCode" parameter

        Resource error               | REST specification        | Bimer ErrorCode
        -------------------------------------------------------------------------
        Get (no resource found)     | 200 OK                    | C01
        Get/id (no resource found)  | 404 Not Found             | C01
        POST (parameter error)      | 422 Unprocessable Entity  | -1
        PUT/id (parameter error)    | 422 Unprocessable Entity  | -1
    */
    /**
     * @param \stdClass|null $data
     * @throws BimerApiException
     */
    private function checkForApiException(\stdClass $data = null): void
    {
        $hasErrors = isset($data->Erros) &&
            isset($data->Erros[0]) &&
            isset($data->Erros[0]->ErrorMessage);

        if ($hasErrors) {
            $code = $data->Erros[0]->ErrorCode ?? null;

            throw new BimerApiException($data->Erros[0]->ErrorMessage, $code);
        }
    }

    /**
     * @param ResponseInterface $response
     * @param \stdClass|null $data
     * @throws BimerRequestException
     */
    private function checkForRequestException(ResponseInterface $response, \stdClass $data = null): void
    {
        $code = $response->getStatusCode();
        $message = $data->error_description ?? $response->getReasonPhrase();

        throw new BimerRequestException($message, $code);
    }

    /**
     * @param \stdClass|null $data
     * @return bool
     */
    private function ignoreException(\stdClass $data = null): bool
    {
        $isGetNotFound = isset($data->Erros) &&
            isset($data->Erros[0]) &&
            isset($data->Erros[0]->ErrorCode) &&
            $data->Erros[0]->ErrorCode == 'C01';

        return $isGetNotFound;
    }

    /**
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function get(string $endpoint = '', array $options = [])
    {
        return $this->request('GET', $endpoint, $options);
    }

    /**
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function post(string $endpoint = '', array $options = [])
    {
        return $this->request('POST', $endpoint, $options);
    }

    /**
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function put(string $endpoint, array $options = [])
    {
        return $this->request('PUT', $endpoint, $options);
    }

    /**
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function delete(string $endpoint, array $options = [])
    {
        return $this->request('PUT', $endpoint, $options);
    }
}
