<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;
use Bimer\Helpers\Validator;
use Bimer\Exceptions\BimerRequestException;

class PostalCode extends Resource
{
    public static function endpoint()
    {
        return 'ceps';
    }

    public static function getByCode($code, $validate = true)
    {
        if ($validate && !Validator::validatePostalCode($code)) {
            throw new BimerRequestException('The parameter "code" must be valid');
        }

        $code = Sanitizer::formatPostalCode($code);

        return static::get("codigo/{$code}");
    }
}
