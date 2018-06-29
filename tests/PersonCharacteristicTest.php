<?php
declare(strict_types=1);

namespace Bimer\Test;

class PersonCharacteristicTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\PersonCharacteristic';
        $this->endpoint = 'pessoa/caracteristicas';
        $this->data = [];
    }

    /** @test */
    public function it_should_create_a_resource()
    {
        // method not implemented on Bimmer API
        $this->expectException(\Exception::class);

        parent::it_should_create_a_resource();
    }
}
