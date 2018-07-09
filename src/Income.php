<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;
use Bimer\Helpers\Validator;

class Income extends Resource
{
    public static function endpoint()
    {
        return 'titulosAReceber';
    }
}
