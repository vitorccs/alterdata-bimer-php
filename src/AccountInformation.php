<?php
namespace Bimer;


use Bimer\Exceptions\BimerApiException;
use Bimer\Http\Resource;

class AccountInformation extends Resource
{
    public static function endpoint()
    {
        return 'naturezasLancamento';
    }

    public static function getByDescription($description, $anyPart = true)
    {
        if (strlen($description) < 1) {
            throw new BimerApiException('The parameter "$description" is required');
        }

        $params = [
            'descricao' => $description,
            'porTrecho' => ($anyPart ? 'true' : 'false')
        ];

        return static::all($params);
    }
}
