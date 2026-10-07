<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use Bimer\PostalCode;

class PostalCodeTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = PostalCode::class;
    }

    public function testGetByCode(): void
    {
        $response = (array)$this->resource::getByCode('01310200');
        $this->assertGreaterThan(0, count($response));
    }
}
