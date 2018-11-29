<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Exceptions\BimerApiException;

class PostalCodeTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\PostalCode';
        $this->endpoint = 'ceps';
    }

    /** @test */
    public function it_should_validate_code()
    {
        $this->expectException(BimerApiException::class);

        $response = $this->resource::getByCode('0');
    }

    /** @test */
    public function it_should_get_by_code()
    {
        $response = (array) $this->resource::getByCode('01310200');
        $this->assertGreaterThan(0, count($response));
    }
}
