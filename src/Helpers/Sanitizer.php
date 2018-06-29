<?php

namespace Bimer\Helpers;

class Sanitizer
{
    public static function cleanNumeric($str)
    {
        return preg_replace("/[^0-9]/", '', $str);
    }
}
