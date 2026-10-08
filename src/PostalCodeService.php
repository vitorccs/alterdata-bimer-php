<?php
declare(strict_types=1);

namespace Bimer;

use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Http\Resource;
use Bimer\Helpers\PostalCodeHelper;
use Bimer\Exceptions\BimerApiException;

class PostalCodeService extends Resource
{
    public function endpoint(): string
    {
        return 'ceps';
    }

    /**
     * @throws BimerApiException
     * @throws BimerRequestException
     * @throws BimerParameterException
     */
    public function getByCode(string $code,
                              bool   $validate = true): ?object
    {
        if ($validate && !PostalCodeHelper::validate($code)) {
            throw new BimerApiException('The parameter "code" must be valid');
        }

        $code = PostalCodeHelper::applyMask($code);

        return $this->get("codigo/{$code}");
    }
}
