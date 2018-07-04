<?php
namespace Bimer\Http;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\TransferStats;

class Client extends Guzzle
{
    protected $fullUrl;

    public function __construct(array $config = [])
    {
        $sdkVersion = Bimer::getSdkVersion();
        $host       = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $url        = &$this->fullUrl;

        $config = array_merge([
            'base_uri'      => Bimer::getApiUrl(),
            'timeout'       => Bimer::getTimeout(),
            'on_stats'      => function (TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri();
            },
            'headers'       => [
                'Content-Type'      => 'application/json',
                'User-Agent'        => "Alterdata-Bimer-PHP/{$sdkVersion};{$host}"
            ]
        ], $config);

        parent::__construct($config);
    }

    public function getToken()
    {
        return Bimer::getToken();
    }

    public function getFullUrl()
    {
        return $this->fullUrl;
    }

    public function setToken($token = null)
    {
        Bimer::setToken($token);
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
