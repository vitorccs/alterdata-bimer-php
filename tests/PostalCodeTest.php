<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Exceptions\BimerApiException;
use Bimer\PostalCode;

class PostalCodeTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = PostalCode::class;
    }

    public function testValidateCode()
    {
        $this->expectException(BimerApiException::class);

        $this->resource::getByCode('0');
    }

    public function testGetByCode()
    {
        $response = (array)$this->resource::getByCode('01310200');
        $this->assertGreaterThan(0, count($response));
    }
}
