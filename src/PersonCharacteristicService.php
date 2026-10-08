<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Http\Resource;

class PersonCharacteristicService extends Resource
{
    public function endpoint(): string
    {
        return 'pessoa/caracteristicas';
    }
}
