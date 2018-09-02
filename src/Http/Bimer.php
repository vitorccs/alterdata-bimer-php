<?php
namespace Bimer\Http;

use Bimer\Exceptions\BimerParameterException;

class Bimer
{
    const BIMER_API_URL                 = 'BIMER_API_URL';
    const BIMER_API_USER                = 'BIMER_API_USER';
    const BIMER_API_PWD                 = 'BIMER_API_PWD';
    const BIMER_API_ID                  = 'BIMER_API_ID';
    const BIMER_API_SECRET              = 'BIMER_API_SECRET';
    const BIMER_API_TIMEOUT             = 'BIMER_API_TIMEOUT';

    private static $apiUrl;
    private static $username;
    private static $password;
    private static $clientId;
    private static $clientSecret;
    private static $timeout;

    private static $defTimeout          = 30; // default timeout in seconds
    private static $tokenDuration       = 10; // token duration in minutes

    private static $token               = null;
    private static $sdkVersion          = 1.0;
    private static $tokenTimestamp      = 0;

    public static function getApiUrl()
    {
        if (!static::$apiUrl) {
            static::$apiUrl = getenv(static::BIMER_API_URL);
        }

        if (!static::$apiUrl) {
            throw new BimerParameterException('Missing '. static::BIMER_API_URL .' parameter');
        }

        return static::$apiUrl;
    }

    public static function getUsername()
    {
        if (!static::$username) {
            static::$username = getenv(static::BIMER_API_USER);
        }

        if (!static::$username) {
            throw new BimerParameterException('Missing '. static::BIMER_API_USER .' parameter');
        }

        return static::$username;
    }

    public static function getPassword()
    {
        if (!static::$password) {
            static::$password = getenv(static::BIMER_API_PWD);
        }

        if (!static::$password) {
            throw new BimerParameterException('Missing '. static::BIMER_API_PWD .' parameter');
        }

        return static::$password;
    }

    public static function getClientId()
    {
        if (!static::$clientId) {
            static::$clientId = getenv(static::BIMER_API_ID);
        }

        if (!static::$clientId) {
            throw new BimerParameterException('Missing '. static::BIMER_API_ID .' parameter');
        }

        return static::$clientId;
    }

    public static function getClientSecret()
    {
        if (!static::$clientSecret) {
            static::$clientSecret = getenv(static::BIMER_API_SECRET);
        }

        if (!static::$clientSecret) {
            throw new BimerParameterException('Missing '. static::BIMER_API_SECRET .' parameter');
        }

        return static::$clientSecret;
    }

    public static function getTimeout()
    {
        if (!static::$timeout) {
            static::$timeout = getenv(static::BIMER_API_TIMEOUT);
        }

        if (!static::$timeout) {
            static::$timeout = static::$defTimeout;
        }

        return static::$timeout;
    }

    public static function getSdkVersion()
    {
        return static::$sdkVersion;
    }

    public static function getToken()
    {
        if (static::minutesLapsed() >= static::$tokenDuration) {
            static::expireToken();
        }

        return static::$token;
    }

    public static function expireToken()
    {
        static::setToken(null);
    }

    public static function setToken($token)
    {
        static::$tokenTimestamp = ($token ? time() : 0);

        static::$token = $token;
    }

    public static function minutesLapsed()
    {
        $to_time    = time();
        $from_time  = static::$tokenTimestamp;
        $mins       = round(abs($to_time - $from_time) / 60, 2);

        return $mins;
    }
}
