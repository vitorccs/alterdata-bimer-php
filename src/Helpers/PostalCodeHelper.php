<?php
declare(strict_types=1);

namespace Bimer\Helpers;

class PostalCodeHelper
{
    const int POSTAL_CODE_LENGTH = 8;

    public static function unmask(?string $value): string
    {
        return Sanitizer::cleanNumeric($value ?? '');
    }

    public static function validate(?string $value): bool
    {
        return strlen(self::unmask($value)) === self::POSTAL_CODE_LENGTH;
    }

    public static function applyMask(?string $value): string
    {
        $value = self::unmask($value);

        return substr($value, 0, 5) . '-' . substr($value, -3);
    }
}
