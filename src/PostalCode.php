<?php

namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;
use Bimer\Helpers\Validator;
use Bimer\Exceptions\BimerApiException;

class PostalCode extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'ceps';
    }

    /**
     * @param $code
     * @param bool $validate
     * @return array|false|mixed|null
     * @throws BimerApiException
     * @throws Exceptions\BimerRequestException
     */
    public static function getByCode($code, bool $validate = true)
    {
        if ($validate && !Validator::validatePostalCode($code)) {
            throw new BimerApiException('The parameter "code" must be valid');
        }

        $code = Sanitizer::formatPostalCode($code);

        return static::get("codigo/{$code}");
    }
}
