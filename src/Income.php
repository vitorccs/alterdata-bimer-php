<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;

class Income extends Resource
{
    public static function endpoint(): string
    {
        return 'titulosAReceber';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function makeBatch(array $params): ?object
    {
        return static::create($params, 'lote/baixas');
    }
}
