<?php
declare(strict_types=1);

namespace Bimer\Http;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Api
{
    private const string AUTH_ENDPOINT = '/oauth/token';

    /**
     * Bimer ErrorCode for "no resource found"
     */
    private const string NOT_FOUND_ERROR_CODE = 'C01';

    protected Client $client;

    /**
     * @throws BimerParameterException
     */
    public function __construct(protected string $endpoint)
    {
        $this->client = new Client();
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

        $nonce = random_int(1, 9999);

        $formParams = [
            ...$credentials,
            'grant_type' => 'password',
            'nonce' => $nonce,
            'password' => md5($credentials['username'] . $nonce . $credentials['password'])
        ];

        $response = $this->post(self::AUTH_ENDPOINT, [
            'form_params' => $formParams
        ]);

        $token = $response->access_token ?? null;

        if (is_null($token)) {
            throw new BimerRequestException('Unable to authenticate');
        }

        $this->client->setToken($token);
    }

    private function fullEndpoint(string $endpoint): string
    {
        return $this->endpoint . '/' . $endpoint;
    }

    private function withAuthHeaders(array $options): array
    {
        return [
            ...$options,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->client->getToken()
            ]
        ];
    }

    /**
     * @throws BimerApiException
     * @throws BimerParameterException
     * @throws BimerRequestException
     */
    public function request(string $method,
                            string $endpoint = '',
                            array  $options = []): mixed
    {
        if ($endpoint !== self::AUTH_ENDPOINT) {
            $this->checkAuth();
            $endpoint = $this->fullEndpoint($endpoint);
            $options = $this->withAuthHeaders($options);
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (RequestException $e) {
            if (!$e->hasResponse()) {
                throw new BimerRequestException($e->getMessage());
            }

            $response = $e->getResponse();
        } catch (GuzzleException $e) {
            throw new BimerRequestException($e->getMessage());
        }

        return $this->response($response);
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     */
    public function response(ResponseInterface $response): mixed
    {
        $data = json_decode($response->getBody()->getContents());

        $this->checkForErrors($response, $data);

        return $data;
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     */
    private function checkForErrors(ResponseInterface $response,
                                    mixed $data): void
    {
        $statusClass = intdiv($response->getStatusCode(), 100);

        if ($statusClass !== 4 && $statusClass !== 5) {
            return;
        }

        if ($this->ignoreException($data)) {
            return;
        }

        $this->checkForApiException($data);
        $this->checkForRequestException($response, $data);
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
     * @throws BimerApiException
     */
    private function checkForApiException(mixed $data): void
    {
        $error = $data->Erros[0] ?? null;

        if (isset($error->ErrorMessage)) {
            throw new BimerApiException((string)$error->ErrorMessage, $error->ErrorCode ?? null);
        }
    }

    /**
     * @throws BimerRequestException
     */
    private function checkForRequestException(ResponseInterface $response,
                                              mixed             $data): never
    {
        $message = $data->error_description ?? $response->getReasonPhrase();

        throw new BimerRequestException((string)$message, $response->getStatusCode());
    }

    private function ignoreException(mixed $data): bool
    {
        return ($data->Erros[0]->ErrorCode ?? null) == self::NOT_FOUND_ERROR_CODE;
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function get(string $endpoint = '',
                        array  $options = []): mixed
    {
        return $this->request('GET', $endpoint, $options);
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function post(string $endpoint = '',
                         array  $options = []): mixed
    {
        return $this->request('POST', $endpoint, $options);
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function put(string $endpoint,
                        array  $options = []): mixed
    {
        return $this->request('PUT', $endpoint, $options);
    }

    /**
     * @throws BimerRequestException
     * @throws BimerApiException
     * @throws BimerParameterException
     */
    public function delete(string $endpoint, array $options = []): mixed
    {
        return $this->request('PUT', $endpoint, $options);
    }
}
