<?php

namespace Bimer\Helpers;

class Sanitizer
{
    public static function cleanNumeric(string $str): string
    {
        return preg_replace("/[^0-9]/", '', $str);
    }

    public static function alphanumericOnly(string $value): string
    {
        return preg_replace("/[^0-9A-Z]/i", '', $value);
    }

    public static function formatPostalCode(string $code): string
    {
        $code = static::cleanNumeric($code);

        return substr($code, 0, 5) .'-'. substr($code, -3);
    }
}
