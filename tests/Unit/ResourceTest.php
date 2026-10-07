<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\AccountInformation;
use Bimer\AreaType;
use Bimer\Customer;
use Bimer\Income;
use Bimer\Person;
use Bimer\PersonCharacteristic;
use Bimer\PostalCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    #[DataProvider('resources')]
    public function testEndpoint(string $resource): void
    {
        $this->assertNotEmpty($resource::endpoint());
    }

    /**
     * Data provider for Resource classes
     */
    public static function resources(): array
    {
        return [
            'AccountInformation' => [AccountInformation::class],
            'AreaType' => [AreaType::class],
            'Customer' => [Customer::class],
            'Income' => [Income::class],
            'Person' => [Person::class],
            'PersonCharacteristic' => [PersonCharacteristic::class],
            'PostalCode' => [PostalCode::class],
        ];
    }
}
