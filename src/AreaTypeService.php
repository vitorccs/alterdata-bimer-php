<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Exceptions\BimerApiException;

class AreaTypeService extends Resource
{
    public function endpoint(): string
    {
        return 'tiposLogradouro';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function getByDescription(string $description,
                                     bool   $anyPart = true): array
    {
        if ($description === '') {
            throw new BimerApiException('The parameter "description" is required');
        }

        $params = [
            'descricao' => $description,
            'porTrecho' => ($anyPart ? 'true' : 'false')
        ];

        return $this->all($params, 'porDescricao');
    }
}
