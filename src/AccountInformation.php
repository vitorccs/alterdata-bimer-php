<?php

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Http\Resource;

class AccountInformation extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'naturezasLancamento';
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

        return static::all($params);
    }
}
