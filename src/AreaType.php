<?php

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
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
     * @param string $description
     * @param bool $anyPart
     * @return array
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function getByDescription(string $description, bool $anyPart = true)
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
