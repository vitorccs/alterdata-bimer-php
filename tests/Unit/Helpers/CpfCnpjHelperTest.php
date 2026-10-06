<?php
declare(strict_types=1);

namespace Bimer\Test\Unit\Helpers;

use Bimer\Helpers\CpfCnpjHelper;
use Bimer\Test\Helpers\GeneratorHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CpfCnpjHelperTest extends TestCase
{
    #[DataProvider('unmaskData')]
    public function testUnmask(?string $value, string $expected)
    {
        $this->assertSame($expected, CpfCnpjHelper::unmask($value));
    }

    #[DataProvider('validCpfData')]
    public function testValidCpf(string $cpf)
    {
        $this->assertTrue(CpfCnpjHelper::validateCpf($cpf));
        $this->assertFalse(CpfCnpjHelper::validateCnpj($cpf));
        $this->assertTrue(CpfCnpjHelper::validate($cpf));
    }

    #[DataProvider('validCnpjData')]
    public function testValidCnpj(string $cnpj)
    {
        $this->assertTrue(CpfCnpjHelper::validateCnpj($cnpj));
        $this->assertFalse(CpfCnpjHelper::validateCpf($cnpj));
        $this->assertTrue(CpfCnpjHelper::validate($cnpj));
    }

    #[DataProvider('invalidData')]
    public function testInvalid(?string $value)
    {
        $this->assertFalse(CpfCnpjHelper::validate($value));
    }

    public static function unmaskData(): array
    {
        return [
            'null' => [null, ''],
            'masked CPF' => ['529.982.247-25', '52998224725'],
            'masked CNPJ' => ['36.462.778/0001-60', '36462778000160'],
            'alphanumeric CNPJ' => ['12.abc.345/01de-35', '12ABC34501DE35'],
        ];
    }

    public static function validCpfData(): array
    {
        return [
            'masked' => ['529.982.247-25'],
            'unmasked' => ['52998224725'],
            'random' => [GeneratorHelper::cpfRandom()],
        ];
    }

    public static function validCnpjData(): array
    {
        return [
            'masked' => ['36.462.778/0001-60'],
            'unmasked' => ['11444777000161'],
            'random' => [GeneratorHelper::cnpjRandom()],
            'alphanumeric' => ['12.ABC.345/01DE-35'],
            'alphanumeric lowercase' => ['12abc34501de35'],
        ];
    }

    public static function invalidData(): array
    {
        return [
            'null' => [null],
            'empty' => [''],
            'wrong CPF digit' => ['529.982.247-26'],
            'repeated CPF' => ['111.111.111-11'],
            'alphanumeric CPF' => ['529.982.24A-25'],
            'wrong CNPJ digit' => ['36.462.778/0001-61'],
            'wrong alphanumeric CNPJ digit' => ['12.ABC.345/01DE-36'],
            'repeated CNPJ' => ['00.000.000/0000-00'],
            'repeated alphanumeric CNPJ' => ['AAAAAAAAAAAAAA'],
            'wrong length' => ['1234567890'],
        ];
    }
}
