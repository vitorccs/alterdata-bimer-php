<?php

namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class AreaType extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'tiposLogradouro';
    }

    /**
     * @param $description
     * @param bool $anyPart
     * @return array|false|mixed|null
     * @throws BimerApiException
     * @throws Exceptions\BimerRequestException
     */
    public static function getByDescription($description, bool $anyPart = true)
    {
        if (strlen($description) < 1) {
            throw new BimerApiException('The parameter "description" is required');
        }

        $params = [
            'descricao' => $description,
            'porTrecho' => ($anyPart ? 'true' : 'false')
        ];

        return static::all($params, "porDescricao");
    }
}
