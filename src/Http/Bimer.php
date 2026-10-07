<?php
declare(strict_types=1);

namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;

class Bimer
{
    const string BIMER_API_URL = 'BIMER_API_URL';
    const string BIMER_API_USER = 'BIMER_API_USER';
    const string BIMER_API_PWD = 'BIMER_API_PWD';
    const string BIMER_API_ID = 'BIMER_API_ID';
    const string BIMER_API_SECRET = 'BIMER_API_SECRET';
    const string BIMER_API_TIMEOUT = 'BIMER_API_TIMEOUT';

    /**
     * Default HTTP timeout in seconds
     */
    const int DEFAULT_TIMEOUT = 30;

    /**
     * Token duration in minutes
     */
    const int TOKEN_DURATION = 10;

    const string SDK_VERSION = '2.0.0';

    private static ?string $apiUrl = null;

    private static ?string $username = null;

    private static ?string $password = null;

    private static ?string $clientId = null;

    private static ?string $clientSecret = null;

    private static ?int $timeout = null;

    private static ?string $token = null;

    /**
     * The timestamp when token was generated
     */
    private static int $tokenTimestamp = 0;

    /**
     * @throws BimerParameterException
     */
    public static function getApiUrl(): string
    {
        return static::$apiUrl ??= static::requireEnv(static::BIMER_API_URL);
    }

    /**
     * @throws BimerParameterException
     */
    public static function getUsername(): string
    {
        return static::$username ??= static::requireEnv(static::BIMER_API_USER);
    }

    /**
     * @throws BimerParameterException
     */
    public static function getPassword(): string
    {
        return static::$password ??= static::requireEnv(static::BIMER_API_PWD);
    }

    /**
     * @throws BimerParameterException
     */
    public static function getClientId(): string
    {
        return static::$clientId ??= static::requireEnv(static::BIMER_API_ID);
    }

    /**
     * @throws BimerParameterException
     */
    public static function getClientSecret(): string
    {
        return static::$clientSecret ??= static::requireEnv(static::BIMER_API_SECRET);
    }

    public static function getTimeout(): int
    {
        return static::$timeout ??= (int)getenv(static::BIMER_API_TIMEOUT) ?: static::DEFAULT_TIMEOUT;
    }

    public static function getSdkVersion(): string
    {
        return static::SDK_VERSION;
    }

    public static function getToken(): ?string
    {
        if (static::minutesLapsed() >= static::TOKEN_DURATION) {
            static::expireToken();
        }

        return static::$token;
    }

    public static function expireToken(): void
    {
        static::setToken();
    }

    public static function setToken(?string $token = null): void
    {
        static::$tokenTimestamp = $token ? time() : 0;
        static::$token = $token;
    }

    public static function minutesLapsed(): float
    {
        return round(abs(time() - static::$tokenTimestamp) / 60, 2);
    }

    /**
     * @throws BimerParameterException
     */
    private static function requireEnv(string $name): string
    {
        $value = getenv($name);

        if ($value === false || $value === '') {
            throw new BimerParameterException("Missing {$name} parameter");
        }

        return $value;
    }
}
