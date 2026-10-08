<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;

class AccountInformationService extends Resource
{
    public function endpoint(): string
    {
        return 'naturezasLancamento';
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

        return $this->all($params);
    }
}
