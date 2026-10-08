<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Helpers\CpfCnpjHelper;
use Bimer\Exceptions\BimerApiException;

class PersonService extends Resource
{
    public function endpoint(): string
    {
        return 'pessoas';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function getByName(string $name,
                              bool   $anyPart = true): array
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

        return $this->all($params, 'porNome');
    }

    /**
     * @throws BimerApiException
     * @throws BimerParameterException
     * @throws BimerRequestException
     */
    public function getByCpfCnpj(string $cpfCnpj,
                                 bool   $validate = true): array
    {
        // Bimer API does not validate "cpfCnpj" parameter, so by performing
        // local validation we save server resources
        if ($validate && !CpfCnpjHelper::validate($cpfCnpj)) {
            throw new BimerApiException('The parameter "cpfCnpj" must be valid');
        }

        $cpfCnpj = CpfCnpjHelper::unmask($cpfCnpj);

        $params = [
            'cpfCnpj' => $cpfCnpj
        ];

        return $this->all($params);
    }
}
