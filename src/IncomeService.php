<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;

class IncomeService extends Resource
{
    public function endpoint(): string
    {
        return 'titulosAReceber';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function makeBatch(array $params): mixed
    {
        return $this->create($params, 'lote/baixas');
    }
}
