<?php
namespace Bimer\Http;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

use Bimer\Exceptions\BimerRequestException;
use Bimer\Exceptions\BimerClientException;

class Api
{
    protected $client;
    protected $endpoint;

    public function __construct($endpoint)
    {
        $this->client = new Client();
        $this->endpoint = $endpoint;
    }

    private function checkAuth()
    {
        if (!$this->client->getToken()) {
            $this->auth();
        }
    }

    private function auth()
    {
        $credentials = $this->client->getCredentials();

        $random = rand(1, 9999);

        $form_params = array_merge($credentials, [
            'grant_type'   => 'password',
            'nonce'        => $random,
            'password'     => md5($credentials['username'].$random.$credentials['password'])
        ]);

        $params = [
            'form_params' => $form_params
        ];

        $response = $this->post('/oauth/token', $params);

        $this->client->setToken($response->access_token);
    }

    private function setFullEndpoint(&$endpoint)
    {
        if (substr($endpoint, 0, 1) == '/') {
            return;
        }

        $endpoint = $this->endpoint .'/'. $endpoint;
    }

    private function setAuthHeaders(&$options)
    {
        if (!$this->client->getToken()) {
            return true;
        }

        $options = array_merge($options, [
            'headers' => [
                'Authorization' => 'Bearer '. $this->client->getToken()
            ]
        ]);
    }

    public function request($method, $endpoint, array $options = [])
    {
        if ($endpoint != '/oauth/token') {
            $this->checkAuth();
        }

        $this->setFullEndpoint($endpoint);
        $this->setAuthHeaders($options);

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if (!$response) {
            throw new BimerClientException('Unable to connect to the host');
        }

        return $this->response($response);
    }

    public function response(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        $data = json_decode($content);

        $this->checkForErrors($response, $data);

        return $data;
    }

    private function checkForErrors(ResponseInterface $response, $data)
    {
        $code           = $response->getStatusCode();
        $statusClass    = (int) ($code / 100);
        $data           = (array) $data;

        if ($statusClass === 4 || $statusClass === 5) {
            switch ($code) {
                case 400:
                    $this->checkForRequestException($data);
                    return;
                default:
                    $this->checkForClientException($data, $response);
                    return;
            }
        }
    }

    /*
        Since Bimer API always responds with a 400 HTTP for all the following,
        we then need to trust on its "ErrorCode" parameter

            Resouce error               | REST specification        | Bimer ErrorCode
            -------------------------------------------------------------------------
            Get (no resource found)     | 200 OK                    | C01
            Get/id (no resource found)  | 404 Not Found             | C01
            POST (parameter error)      | 422 Unprocessable Entity  | -1
            PUT/id (parameter error)    | 422 Unprocessable Entity  | -1
    */
    private function checkForRequestException($data)
    {
        $hasErrors = isset($data['Erros']) &&
                        isset($data['Erros'][0]) &&
                        isset($data['Erros'][0]->ErrorMessage);

        $isNotFoundError = isset($data['Erros']) &&
                        isset($data['Erros'][0]) &&
                        isset($data['Erros'][0]->ErrorCode) &&
                        $data['Erros'][0]->ErrorCode == 'C01';

        if ($hasErrors && !$isNotFoundError) {
            throw new BimerRequestException($data['Erros'][0]->ErrorMessage);
        }
    }

    private function checkForClientException($data, $response)
    {
        $code        = $response->getStatusCode();
        $reason      = $response->getReasonPhrase();
        $description = isset($data['error_description']) ? $data['error_description'] : '';
        $message     = "{$code} ($reason) {$description}";

        throw new BimerClientException($message);
    }

    public function get($endpoint, array $options = [])
    {
        return $this->request('GET', $endpoint, $options);
    }

    public function post($endpoint, array $options = [])
    {
        return $this->request('POST', $endpoint, $options);
    }

    public function put($endpoint, array $options = [])
    {
        return $this->request('PUT', $endpoint, $options);
    }

    public function delete($endpoint, array $options = [])
    {
        return $this->request('PUT', $endpoint, $options);
    }
}
