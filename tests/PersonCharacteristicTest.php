<?php
declare(strict_types=1);

namespace Bimer\Test;

class PersonCharacteristicTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\PersonCharacteristic';
        $this->endpoint = 'pessoa/caracteristicas';
    }

    /** @test */
    public function it_should_retrieve_all_resources()
    {
        $response = $this->resource::all();
        $this->assertGreaterThan(0, count($response));
    }
}
