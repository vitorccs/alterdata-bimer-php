<?php

namespace Bimer;

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
     * @return array|false|mixed|null
     * @throws Exceptions\BimerApiException
     * @throws Exceptions\BimerRequestException
     */
    public static function makeBatch(array $params)
    {
        return static::create($params, "lote/baixas");
    }
}
