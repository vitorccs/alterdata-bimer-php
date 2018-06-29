<?php
namespace Bimer;

use Bimer\Http\Resource;

class Customer extends Resource
{
    public static function endpoint()
    {
        return 'clientes';
    }
}
