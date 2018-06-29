<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;

class Person extends Resource
{
    public static function endpoint()
    {
        return 'pessoas';
    }

    public static function getByName($name, $anyPart = true)
    {
        $params = [
            'nome'      => $name,
            'porTrecho' => ($anyPart ? 'true' : 'false')
        ];

        return static::all($params, 'porNome');
    }

    public static function getByCpfCnpj($cpfCnpj)
    {
        $cpfCnpj = Sanitizer::cleanNumeric($cpfCnpj);

        $params = [
            'cpfCnpj'   => $cpfCnpj
        ];

        return static::all($params);
    }
}
