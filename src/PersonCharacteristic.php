<?php

namespace Bimer;

use Bimer\Http\Resource;

class PersonCharacteristic extends Resource
{
    public static function endpoint(): string
    {
        return 'pessoa/caracteristicas';
    }
}
