<?php

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;

class Income extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'titulosAReceber';
    }

    /**
     * @param array $params
     * @return \stdClass
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function makeBatch(array $params)
    {
        return static::create($params, "lote/baixas");
    }
}
