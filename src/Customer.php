<?php

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class Customer extends Resource
{
    public static function endpoint(): string
    {
        return 'clientes';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function create(array  $params,
                                  string $endpoint = ''): object
    {
        // NOTE: Bimer API makes no parameters validation
        // In case of invalid data, the HTTP will fail with 500 error code
        if (!isset($params['Nome'])) {
            throw new BimerApiException('The parameter "Nome" is mandatory');
        }

        return parent::create($params);
    }
}
