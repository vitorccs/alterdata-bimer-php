<?php
namespace Bimer\Http;

class Bimer
{
		protected static $apiUrl 				= null;
		protected static $username 			= null;
		protected static $password 			= null;
		protected static $clientId			= null;
		protected static $clientSecret	= null;
		protected static $token					= null;
		protected static $sdkVersion 		= 0.9;
		protected static $timeout 			= 60;

		public static function getApiUrl()
    {
				if (!static::$apiUrl) {
						static::$apiUrl = getenv('BIMER_API_URL');
				}

				if (!static::$apiUrl) {
						throw new \Exception('Missing BIMER_API_URL parameter');
				}

				return static::$apiUrl;
    }

		public static function getUsername()
    {
				if (!static::$username) {
						static::$username = getenv('BIMER_API_USER');
				}

				if (!static::$username) {
						throw new \Exception('Missing BIMER_API_USER parameter');
				}

				return static::$username;
    }

		public static function getPassword()
    {
				if (!static::$password) {
						static::$password = getenv('BIMER_API_PWD');
				}

				if (!static::$password) {
						throw new \Exception('Missing BIMER_API_PWD parameter');
				}

				return static::$password;
    }

		public static function getClientId()
    {
				if (!static::$clientId) {
						static::$clientId = getenv('BIMER_API_ID');
				}

				if (!static::$clientId) {
						throw new \Exception('Missing BIMER_API_ID parameter');
				}

				return static::$clientId;
    }

		public static function getClientSecret()
    {
				if (!static::$clientSecret) {
						static::$clientSecret = getenv('BIMER_API_SECRET');
				}

				if (!static::$clientSecret) {
						throw new \Exception('Missing BIMER_API_SECRET parameter');
				}

				return static::$clientId;
    }

		public static function getSdkVersion()
    {
				return static::$sdkVersion;
    }

		public static function getTimeout()
    {
				return static::$timeout;
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
