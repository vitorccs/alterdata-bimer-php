<?php
namespace Bimer\Http;

class Bimer
{
    const BIMER_API_URL					= 'BIMER_API_URL';
    const BIMER_API_USER				= 'BIMER_API_USER';
    const BIMER_API_PWD					= 'BIMER_API_PWD';
    const BIMER_API_ID					= 'BIMER_API_ID';
    const BIMER_API_SECRET				= 'BIMER_API_SECRET';
    const BIMER_API_TIMEOUT				= 'BIMER_API_TIMEOUT';

    private static $apiUrl;
    private static $username;
    private static $password;
    private static $clientId;
    private static $clientSecret;
    private static $timeout;

    private static $token				= null;
    private static $sdkVersion			= 0.9;
    private static $defTimeout			= 30;

    public static function getApiUrl()
    {
        if (!static::$apiUrl) {
            static::$apiUrl = getenv(static::BIMER_API_URL);
        }

        if (!static::$apiUrl) {
            throw new \Exception('Missing '. static::BIMER_API_URL .' parameter');
        }

        return static::$apiUrl;
    }

    public static function getUsername()
    {
        if (!static::$username) {
            static::$username = getenv(static::BIMER_API_USER);
        }

        if (!static::$username) {
            throw new \Exception('Missing '. static::BIMER_API_USER .' parameter');
        }

        return static::$username;
    }

    public static function getPassword()
    {
        if (!static::$password) {
            static::$password = getenv(static::BIMER_API_PWD);
        }

        if (!static::$password) {
            throw new \Exception('Missing '. static::BIMER_API_PWD .' parameter');
        }

        return static::$password;
    }

    public static function getClientId()
    {
        if (!static::$clientId) {
            static::$clientId = getenv(static::BIMER_API_ID);
        }

        if (!static::$clientId) {
            throw new \Exception('Missing '. static::BIMER_API_ID .' parameter');
        }

        return static::$clientId;
    }

    public static function getClientSecret()
    {
        if (!static::$clientSecret) {
            static::$clientSecret = getenv(static::BIMER_API_SECRET);
        }

        if (!static::$clientSecret) {
            throw new \Exception('Missing '. static::BIMER_API_SECRET .' parameter');
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
        return static::$token;
    }

    public static function setToken($token)
    {
        static::$token = $token;
    }
}
