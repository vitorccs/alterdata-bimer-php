<?php
declare(strict_types=1);

namespace Bimer\Test\Unit\Helpers;

use Bimer\Helpers\PostalCodeHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PostalCodeHelperTest extends TestCase
{
    #[DataProvider('unmaskData')]
    public function testUnmask(?string $value, string $expected): void
    {
        $this->assertSame($expected, PostalCodeHelper::unmask($value));
    }

    #[DataProvider('validateData')]
    public function testValidate(?string $value, bool $expected): void
    {
        $this->assertSame($expected, PostalCodeHelper::validate($value));
    }

    #[DataProvider('applyMaskData')]
    public function testApplyMask(?string $value, string $expected): void
    {
        $this->assertSame($expected, PostalCodeHelper::applyMask($value));
    }

    public static function unmaskData(): array
    {
        return [
            'null' => [null, ''],
            'masked' => ['01310-200', '01310200'],
            'unmasked' => ['01310200', '01310200'],
            'with letters' => ['AB01310-200', '01310200'],
        ];
    }

    public static function validateData(): array
    {
        return [
            'null' => [null, false],
            'empty' => ['', false],
            'masked' => ['01310-200', true],
            'unmasked' => ['01310200', true],
            'too short' => ['0131020', false],
            'too long' => ['013102000', false],
        ];
    }

    public static function applyMaskData(): array
    {
        return [
            'unmasked' => ['01310200', '01310-200'],
            'masked' => ['01310-200', '01310-200'],
            'with dots' => ['01.310-200', '01310-200'],
        ];
    }
}
