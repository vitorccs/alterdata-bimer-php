<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use Bimer\PersonCharacteristic;

class PersonCharacteristicTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = PersonCharacteristic::class;
    }

    public function testGetArray()
    {
        $response = $this->resource::all();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, count($response));
    }
}
