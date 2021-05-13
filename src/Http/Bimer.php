<?php

namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;

class Bimer
{
    /**
     *
     */
    const BIMER_API_URL = 'BIMER_API_URL';
    /**
     *
     */
    const BIMER_API_USER = 'BIMER_API_USER';
    /**
     *
     */
    const BIMER_API_PWD = 'BIMER_API_PWD';
    /**
     *
     */
    const BIMER_API_ID = 'BIMER_API_ID';
    /**
     *
     */
    const BIMER_API_SECRET = 'BIMER_API_SECRET';
    /**
     *
     */
    const BIMER_API_TIMEOUT = 'BIMER_API_TIMEOUT';

    /**
     * @var string|null
     */
    private static $apiUrl;

    /**
     * @var string|null
     */
    private static $username;

    /**
     * @var string|null
     */
    private static $password;

    /**
     * @var string|null
     */
    private static $clientId;

    /**
     * @var string|null
     */
    private static $clientSecret;

    /**
     * The HTTP connection timeout
     *
     * @var int
     */
    private static $timeout;

    /**
     * Default timeout in seconds
     *
     * @var int
     */
    private static $defTimeout = 30;

    /**
     * Token duration in minutes
     *
     * @var int
     */
    private static $tokenDuration = 10;

    /**
     * The current token value
     *
     * @var string|null
     */
    private static $token = null;

    /**
     * @var string
     */
    private static $sdkVersion = "1.2.0";

    /**
     * The timestamp when token was generated
     *
     * @var int
     */
    private static $tokenTimestamp = 0;

    /**
     * @return string
     * @throws BimerParameterException
     */
    public static function getApiUrl(): string
    {
        if (!static::$apiUrl) {
            static::$apiUrl = getenv(static::BIMER_API_URL);
        }

        if (!static::$apiUrl) {
            throw new BimerParameterException('Missing ' . static::BIMER_API_URL . ' parameter');
        }

        return static::$apiUrl;
    }

    /**
     * @return string
     * @throws BimerParameterException
     */
    public static function getUsername(): ?string
    {
        if (!static::$username) {
            static::$username = getenv(static::BIMER_API_USER);
        }

        if (!static::$username) {
            throw new BimerParameterException('Missing ' . static::BIMER_API_USER . ' parameter');
        }

        return static::$username;
    }

    /**
     * @return string
     * @throws BimerParameterException
     */
    public static function getPassword(): string
    {
        if (!static::$password) {
            static::$password = getenv(static::BIMER_API_PWD);
        }

        if (!static::$password) {
            throw new BimerParameterException('Missing ' . static::BIMER_API_PWD . ' parameter');
        }

        return static::$password;
    }

    /**
     * @return string
     * @throws BimerParameterException
     */
    public static function getClientId(): ?string
    {
        if (!static::$clientId) {
            static::$clientId = getenv(static::BIMER_API_ID);
        }

        if (!static::$clientId) {
            throw new BimerParameterException('Missing ' . static::BIMER_API_ID . ' parameter');
        }

        return static::$clientId;
    }

    /**
     * @return string
     * @throws BimerParameterException
     */
    public static function getClientSecret(): string
    {
        if (!static::$clientSecret) {
            static::$clientSecret = getenv(static::BIMER_API_SECRET);
        }

        if (!static::$clientSecret) {
            throw new BimerParameterException('Missing ' . static::BIMER_API_SECRET . ' parameter');
        }

        return static::$clientSecret;
    }

    /**
     * @return int
     */
    public static function getTimeout(): int
    {
        if (!static::$timeout) {
            static::$timeout = intval(getenv(static::BIMER_API_TIMEOUT));
        }

        if (!static::$timeout) {
            static::$timeout = static::$defTimeout;
        }

        return static::$timeout;
    }

    /**
     * @return string
     */
    public static function getSdkVersion(): string
    {
        return static::$sdkVersion;
    }

    /**
     * @return string|null
     */
    public static function getToken(): ?string
    {
        if (static::minutesLapsed() >= static::$tokenDuration) {
            static::expireToken();
        }

        return static::$token;
    }

    /**
     *
     */
    public static function expireToken(): void
    {
        static::setToken();
    }

    /**
     * @param string|null $token
     */
    public static function setToken(string $token = null): void
    {
        static::$tokenTimestamp = $token ? time() : 0;

        static::$token = $token;
    }

    /**
     * @return float
     */
    public static function minutesLapsed(): float
    {
        $toTime = time();
        $fromTime = static::$tokenTimestamp;
        $mins = round(abs($toTime - $fromTime) / 60, 2);

        return $mins;
    }
}
