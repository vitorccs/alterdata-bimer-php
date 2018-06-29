<?php
namespace Bimer\Http;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

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
            throw new \Exception('Unable to connect to the host');
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
        $fullUrl        = $this->client->getFullUrl();
        $code           = $response->getStatusCode();
        $reason         = $response->getReasonPhrase();
        $statusClass    = (int) ($code / 100);
        $data           = (array) $data;

        $message        = isset($data['error_description']) ? $data['error_description'] : '';

        if ($statusClass === 4 || $statusClass === 5) {
            switch ($code) {
                case 400:
                    // This code is used by Bimmer API when trying to get that could not be found
                    // so let's normalize to always return an empty (null) value in such cases
                    return;
                case 404:
                case 405:
                    // These code are used by Bimmer API when the method is not implemeted
                    throw new \Exception("Method not implemented for this resource");
                default:
                    throw new \Exception("{$code} ($reason) {$message} ($fullUrl)");
            }
        }
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
