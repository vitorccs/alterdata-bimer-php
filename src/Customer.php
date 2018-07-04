<?php
namespace Bimer;

use Bimer\Http\Resource;
use Bimer\Exceptions\BimerRequestException;

class Customer extends Resource
{
    public static function endpoint()
    {
        return 'clientes';
    }

    public static function create(array $params)
    {
        // Bimer API does not validate any parameters
        // If missing a mandatory parameter, rather than warning the user
        // instead triggers 500 error code with a message that is not clear
        if (!isset($params['Nome'])) {
            throw new BimerRequestException('The parameter "Nome" is mandatory');
        }

        return parent::create($params);
    }
}
