<?php

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
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

        return static::all($params);
    }
}
