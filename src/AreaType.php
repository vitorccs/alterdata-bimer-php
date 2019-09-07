<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class AreaType extends Resource
{
    public static function endpoint()
    {
        return 'tiposLogradouro';
    }

    public static function getByDescription($description, $anyPart = true)
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
