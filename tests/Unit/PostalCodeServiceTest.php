<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\Exceptions\BimerApiException;
use Bimer\PostalCodeService;
use PHPUnit\Framework\TestCase;

class PostalCodeServiceTest extends TestCase
{
    public function testValidateCode(): void
    {
        $this->expectException(BimerApiException::class);

        (new PostalCodeService())->getByCode('0');
    }
}
