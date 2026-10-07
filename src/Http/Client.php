<?php
declare(strict_types=1);

namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected ClientInterface $http;

    protected ?string $fullUrl = null;

    /**
     * @param array $config Guzzle request options merged into the defaults
     * @param ClientInterface|null $http Custom HTTP client (e.g.: for testing)
     * @throws BimerParameterException
     */
    public function __construct(array $config = [],
                                ?ClientInterface $http = null)
    {
        $this->http = $http ?? new Guzzle(array_merge($this->defaultConfig(), $config));
    }

    /**
     * @throws GuzzleException
     */
    public function request(string $method,
                            string $uri = '',
                            array  $options = []): ResponseInterface
    {
        $this->fullUrl = null;

        $onStats = $options['on_stats'] ?? null;

        $options['on_stats'] = function (TransferStats $stats) use ($onStats) {
            $this->fullUrl = (string)$stats->getEffectiveUri();

            if (is_callable($onStats)) {
                $onStats($stats);
            }
        };

        return $this->http->request($method, $uri, $options);
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->http;
    }

    public function getToken(): ?string
    {
        return Bimer::getToken();
    }

    public function getFullUrl(): ?string
    {
        return $this->fullUrl;
    }

    public function setToken(?string $token = null): void
    {
        Bimer::setToken($token);
    }

    /**
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

    /**
     * @throws BimerParameterException
     */
    protected function defaultConfig(): array
    {
        $sdkVersion = Bimer::getSdkVersion();
        $host = $_SERVER['HTTP_HOST'] ?? '';

        return [
            'base_uri' => Bimer::getApiUrl(),
            'timeout' => Bimer::getTimeout(),
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent' => "Alterdata-Bimer-PHP/{$sdkVersion};{$host}"
            ]
        ];
    }
}
