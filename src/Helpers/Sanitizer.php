<?php
declare(strict_types=1);

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
}
