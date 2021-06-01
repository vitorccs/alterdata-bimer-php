<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Customer;
use Bimer\Exceptions\BimerApiException;

class CustomerTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = Customer::class;
    }

    public function testCreateCustomer()
    {
        $invalidParameters = [];
        $this->expectException(BimerApiException::class);
        $this->resource::create($invalidParameters);
    }
}
