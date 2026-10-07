<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\Customer;
use Bimer\Exceptions\BimerApiException;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCreateCustomer(): void
    {
        $invalidParameters = [];
        $this->expectException(BimerApiException::class);
        Customer::create($invalidParameters);
    }
}
