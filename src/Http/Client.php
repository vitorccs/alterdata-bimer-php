<?php
namespace Bimer\Http;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\TransferStats;

class Client extends Guzzle
{
    protected $apiUrl;
    protected $timeout;
    protected $sdkVersion;
    protected $token;
    protected $fullUrl;

    public function __construct(array $config = [])
    {
        $this->apiUrl           = Bimer::getApiUrl();
        $this->timeout          = Bimer::getTimeout();
        $this->sdkVersion       = Bimer::getSdkVersion();
        $this->token            = Bimer::getToken();

        $host       = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $url        = &$this->fullUrl;

        $config = array_merge([
            'base_uri'      => $this->apiUrl,
            'timeout'       => $this->timeout,
            'on_stats'      => function (TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri();
            },
            'headers'       => [
                'Content-Type'      => 'application/json',
                'User-Agent'        => "Alterdata-Bimer-PHP/{$this->sdkVersion};{$host}"
            ]
        ], $config);

        parent::__construct($config);
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getFullUrl()
    {
        return $this->fullUrl;
    }

    public function setToken($token)
    {
        // make token available for all further requests
        Bimer::setToken($token);

        $this->token = $token;
    }

    public function getCredentials()
    {
        $credentials = [
            'username'        => Bimer::getUsername(),
            'password'        => Bimer::getPassword(),
            'client_id'       => Bimer::getClientId(),
            'client_secret'   => Bimer::getClientSecret()
        ];

        return $credentials;
    }
}
