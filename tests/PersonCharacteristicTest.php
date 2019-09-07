<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\PersonCharacteristic;

class PersonCharacteristicTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = PersonCharacteristic::class;
    }

    /** @test */
    public function it_should_retrieve_all_resources()
    {
        $response = $this->resource::all();
        $this->assertGreaterThan(0, count($response));
    }
}
