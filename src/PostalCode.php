<?php

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Helpers\PostalCodeHelper;
use Bimer\Exceptions\BimerApiException;

class PostalCode extends Resource
{
    public static function endpoint(): string
    {
        return 'ceps';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function getByCode(string $code,
                                     bool   $validate = true)
    {
        if ($validate && !PostalCodeHelper::validate($code)) {
            throw new BimerApiException('The parameter "code" must be valid');
        }

        $code = PostalCodeHelper::applyMask($code);

        return static::get("codigo/{$code}");
    }
}
