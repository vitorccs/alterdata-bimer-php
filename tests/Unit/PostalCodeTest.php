<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\Exceptions\BimerApiException;
use Bimer\PostalCode;
use PHPUnit\Framework\TestCase;

class PostalCodeTest extends TestCase
{
    public function testValidateCode(): void
    {
        $this->expectException(BimerApiException::class);

        PostalCode::getByCode('0');
    }
}
