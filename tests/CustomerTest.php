<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Exceptions\BimerRequestException;

class CustomerTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\Customer';
        $this->endpoint = 'clientes';
        $this->data = [
            'Nome' => 'Creating Customer #'. rand()
        ];
    }

    /** @test */
    public function it_should_not_create_a_resource()
    {
        $invalidParameters = [];
        $this->expectException(BimerRequestException::class);
        $this->resource::create($invalidParameters);
    }

    /** @test */
    public function it_should_create_a_resource()
    {
        $customer = $this->resource::create($this->data);
        $this->assertObjectHasAttribute('Identificador', $customer);
    }
}
