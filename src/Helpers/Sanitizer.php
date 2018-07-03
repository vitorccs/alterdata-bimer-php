<?php

namespace Bimer\Helpers;

class Sanitizer
{
    public static function cleanNumeric($str)
    {
        return preg_replace("/[^0-9]/", '', $str);
    }

    public static function formatPostalCode($code)
    {
        $code = static::cleanNumeric($code);

        return substr($code, 0, 5) .'-'. substr($code, -3);
    }
}
