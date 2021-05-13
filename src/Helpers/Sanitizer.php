<?php

namespace Bimer\Helpers;

class Sanitizer
{
    /**
     * @param $str
     * @return string
     */
    public static function cleanNumeric($str): string
    {
        return preg_replace("/[^0-9]/", '', $str);
    }

    /**
     * @param $code
     * @return string
     */
    public static function formatPostalCode($code): string
    {
        $code = static::cleanNumeric($code);

        return substr($code, 0, 5) .'-'. substr($code, -3);
    }
}
