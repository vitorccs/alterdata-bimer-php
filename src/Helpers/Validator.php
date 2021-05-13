<?php

namespace Bimer\Helpers;


class Validator
{
    /**
     * The CPF chars length
     */
    CONST CPF_CHARS_LENGTH = 11;

    /**
     * The CNPJ chars length
     */
    const CNPJ_CHARS_LENGTH = 14;

    /**
     * The Postal Code chars length
     */
    const POSTAL_CODE_LENGTH = 8;

    /**
     * @param string|int|null $value
     * @return string|null
     */
    public static function unmask($value = null): string
    {
        return Sanitizer::cleanNumeric($value);
    }

    /**
     * @param string|int|null $cnpj
     * @return bool
     */
    public static function validateCnpj($cnpj): bool
    {
        $cnpj = self::unmask($cnpj);

        if (strlen($cnpj) !== self::CNPJ_CHARS_LENGTH) {
            return false;
        }

        // validate first verifying digit
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        if ($cnpj[12] != ($remainder < 2 ? 0 : 11 - $remainder)) {
            return false;
        }

        // validate second verifying digit
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        return $cnpj[13] == ($remainder < 2 ? 0 : 11 - $remainder);
    }

    /**
     * @param string|int|null $cpf
     * @return bool
     */
    public static function validateCpf($cpf): bool
    {
        $cpf = self::unmask($cpf);

        if (strlen($cpf) !== self::CPF_CHARS_LENGTH) {
            return false;
        }

        // check for invalid list of numbers
        elseif ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
            // validate verifying digit
        } else {
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

    /**
     * @param string|int|null $value
     * @return bool
     */
    public static function validateCpfCnpj($value): bool
    {
        return self::validateCpf($value) || self::validateCnpj($value);
    }

    /**
     * @param string|int|null $value
     * @return bool
     */
    public static function validatePostalCode($value): bool
    {
        $value = Sanitizer::cleanNumeric($value);
        return strlen($value) === self::POSTAL_CODE_LENGTH;
    }
}
