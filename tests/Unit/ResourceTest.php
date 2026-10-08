<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\AccountInformationService;
use Bimer\AreaTypeService;
use Bimer\CustomerService;
use Bimer\IncomeService;
use Bimer\PersonService;
use Bimer\PersonCharacteristicService;
use Bimer\PostalCodeService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    #[DataProvider('resources')]
    public function testEndpoint(string $resource): void
    {
        $this->assertNotEmpty((new $resource())->endpoint());
    }

    /**
     * Data provider for Resource classes
     */
    public static function resources(): array
    {
        return [
            'AccountInformationService' => [AccountInformationService::class],
            'AreaTypeService' => [AreaTypeService::class],
            'CustomerService' => [CustomerService::class],
            'IncomeService' => [IncomeService::class],
            'PersonService' => [PersonService::class],
            'PersonCharacteristicService' => [PersonCharacteristicService::class],
            'PostalCodeService' => [PostalCodeService::class],
        ];
    }
}
