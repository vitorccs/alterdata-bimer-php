<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;

class PostalCode extends Resource
{
    public static function endpoint()
    {
        return 'ceps';
    }

    public static function getByCode($code)
    {
        $code = Sanitizer::formatPostalCode($code);

        return static::get("codigo/{$code}");
    }
}
