<?php

namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\TransferStats;

class Client extends Guzzle
{
    /**
     * @var string|null
     */
    protected $fullUrl;

    /**
     * @throws BimerParameterException
     */
    public function __construct(array $config = [])
    {
        $sdkVersion = Bimer::getSdkVersion();
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $url = &$this->fullUrl;

        $config = array_merge([
            'base_uri' => Bimer::getApiUrl(),
            'timeout' => Bimer::getTimeout(),
            'on_stats' => function (TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri();
            },
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent' => "Alterdata-Bimer-PHP/{$sdkVersion};{$host}"
            ]
        ], $config);

        parent::__construct($config);
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return Bimer::getToken();
    }

    /**
     * @return string|null
     */
    public function getFullUrl(): ?string
    {
        return $this->fullUrl;
    }

    /**
     * @param string|null $token
     */
    public function setToken(string $token = null)
    {
        Bimer::setToken($token);
    }

    /**
     * @return array
     * @throws BimerParameterException
     */
    public function getCredentials(): array
    {
        return [
            'username' => Bimer::getUsername(),
            'password' => Bimer::getPassword(),
            'client_id' => Bimer::getClientId(),
            'client_secret' => Bimer::getClientSecret()
        ];
    }
}
