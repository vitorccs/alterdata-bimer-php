<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\CustomerService;
use Bimer\Exceptions\BimerApiException;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    public function testCreateCustomer(): void
    {
        $invalidParameters = [];
        $this->expectException(BimerApiException::class);
        (new CustomerService())->create($invalidParameters);
    }
}
