<?php

namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class Customer extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'clientes';
    }

    /**
     * @param array $params
     * @param string|null $endpoint
     * @return array|false|mixed|null
     * @throws BimerApiException
     * @throws Exceptions\BimerRequestException
     */
    public static function create(array $params, string $endpoint = null)
    {
        // NOTE: Bimer API makes no parameters validation
        // In case of invalid data, the HTTP will fail with 500 error code
        if (!isset($params['Nome'])) {
            throw new BimerApiException('The parameter "Nome" is mandatory');
        }

        return parent::create($params);
    }
}
