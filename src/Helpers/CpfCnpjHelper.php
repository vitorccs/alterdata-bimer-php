<?php

namespace Bimer\Helpers;

class CpfCnpjHelper
{
    /**
     * The CPF chars length
     */
    const int CPF_CHARS_LENGTH = 11;

    /**
     * The CNPJ chars length
     */
    const int CNPJ_CHARS_LENGTH = 14;

    public static function unmask(?string $value): string
    {
        return Sanitizer::alphanumericOnly(strtoupper($value ?? ''));
    }

    public static function validate(?string $value): bool
    {
        return self::validateCpf($value) || self::validateCnpj($value);
    }

    public static function validateCnpj(?string $cnpj): bool
    {
        $cnpj = self::unmask($cnpj);

        // invalid length
        if (strlen($cnpj) !== self::CNPJ_CHARS_LENGTH) {
            return false;
        }

        // contains a repeated sequence of the same char
        if (preg_match('/^(.)\1{13}$/', $cnpj)) {
            return false;
        }

        $checkDigit = function ($pos) use ($cnpj) {
            $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            $asciiOffset = 48; // '0' => 0, '9' => 9, 'A' => 17, 'Z' => 42
            $sum = 0;
            for ($i = 0; $i < $pos; $i++) {
                $sum += (ord($cnpj[$i]) - $asciiOffset) * $weights[$i + ($pos === 12)];
            }
            $n = $sum % 11;
            return $cnpj[$pos] == ($n < 2 ? 0 : 11 - $n);
        };

        return $checkDigit(12) && $checkDigit(13);
    }

    public static function validateCpf(?string $cpf): bool
    {
        $cpf = self::unmask($cpf);

        // invalid length
        if (strlen($cpf) !== self::CPF_CHARS_LENGTH) {
            return false;
        }

        // contains non-numeric chars
        if (!ctype_digit($cpf)) {
            return false;
        }

        // contains a repeated sequence of the same number
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // validate verifying digit
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
