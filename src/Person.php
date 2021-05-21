<?php

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Helpers\Sanitizer;
use Bimer\Helpers\Validator;
use Bimer\Exceptions\BimerApiException;

class Person extends Resource
{
    /**
     * @return string
     */
    public static function endpoint(): string
    {
        return 'pessoas';
    }

    /**
     * @param string $name
     * @param bool $anyPart
     * @return array
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function getByName(string $name, bool $anyPart = true)
    {
        // Bimer API does not validate "name" parameter. So an empty "name"
        // parameter combined with "anyPart" might try to return the entire table!
        if (strlen($name) < 3) {
            throw new BimerApiException('The parameter "name" must be at least 3 chars length');
        }

        $params = [
            'nome' => $name,
            'porTrecho' => ($anyPart ? 'true' : 'false')
        ];

        return static::all($params, 'porNome');
    }

    /**
     * @param string|int $cpfCnpj
     * @param bool $validate
     * @return array
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public static function getByCpfCnpj($cpfCnpj, bool $validate = true)
    {
        // Bimer API does not validate "cpfCnpj" parameter, so by performing
        // local validation we save server resources
        if ($validate && !Validator::validateCpfCnpj($cpfCnpj)) {
            throw new BimerApiException('The parameter "cpfCnpj" must be valid');
        }

        $cpfCnpj = Sanitizer::cleanNumeric($cpfCnpj);

        $params = [
            'cpfCnpj' => $cpfCnpj
        ];

        return static::all($params);
    }
}
