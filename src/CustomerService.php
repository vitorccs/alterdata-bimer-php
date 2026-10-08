<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class CustomerService extends Resource
{
    public function endpoint(): string
    {
        return 'clientes';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function create(array  $params,
                           string $endpoint = ''): mixed
    {
        // NOTE: Bimer API makes no parameters validation
        // In case of invalid data, the HTTP will fail with 500 error code
        if (!isset($params['Nome'])) {
            throw new BimerApiException('The parameter "Nome" is mandatory');
        }

        return parent::create($params, $endpoint);
    }
}
