<?php
namespace Bimer;

use Bimer\Http\Resource;

class PersonCharacteristic extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'pessoa/caracteristicas';
    }
}
