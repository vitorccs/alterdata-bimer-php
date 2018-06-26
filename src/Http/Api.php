<?php
namespace Bimer\Http;

use Psr\Http\Message\ResponseInterface;

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
						'grant_type'		=> 'password',
						'nonce'					=> $random,
						'password'			=> md5($credentials['username'].$random.$credentials['password'])
				]);

				$params = [
						'form_params' => $form_params
				];

				$response = $this->post('/oauth/token', $params);

				$this->client->setToken($response->access_token);
		}

		private function getUrl($endpoint)
		{
				if (substr($endpoint, 0, 1) == '/') {
						return $endpoint;
				}

				if ($endpoint) {
						return $this->endpoint .'/'. $endpoint;
				}

				return $this->endpoint;
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

				$url = $this->getUrl($endpoint);

				$this->setAuthHeaders($options);

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (\Exception $e) {
            $response = $e->getResponse();
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
				$fullUrl			= $this->client->getFullUrl();
				$code 				= $response->getStatusCode();
				$reason 			= $response->getReasonPhrase();
				$statusClass 	= (int) ($code / 100);
				$data 				= (array) $data;

				$message			= $data['error_description'] ?? '';

				if ($statusClass === 4 || $statusClass === 5) {
						switch ($code) {
								case 400:
									throw new \Exception("{$code} ($reason) {$message}");
								case 404:
										throw new \Exception("{$code} ($reason) {$message} ($fullUrl)");
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
