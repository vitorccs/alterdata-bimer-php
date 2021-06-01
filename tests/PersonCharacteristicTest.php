<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\PersonCharacteristic;

class PersonCharacteristicTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = PersonCharacteristic::class;
    }

    public function testGetArray()
    {
        $response = $this->resource::all();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, count($response));
    }
}
