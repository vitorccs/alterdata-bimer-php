<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Customer;
use Bimer\Exceptions\BimerApiException;

class CustomerTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = Customer::class;
    }

    /** @test */
    public function it_should_not_create_a_resource()
    {
        $invalidParameters = [];
        $this->expectException(BimerApiException::class);
        $this->resource::create($invalidParameters);
    }
}
