<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use Bimer\AccountInformation;

class AccountInformationTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = AccountInformation::class;
    }

    #[DataProvider('accountData')]
    public function testGetByDescription(array $accountData)
    {
        $response = $this->resource::getByDescription($accountData['description']);

        $this->assertGreaterThan(0, count($response));
    }

    #[DataProvider('accountData')]
    public function testGetById(array $accountData)
    {
        $accountInformation = $this->resource::find($accountData['id']);
        $this->assertObjectHasProperty('Identificador', $accountInformation);
    }

    /**
     * Data provider for Account Data
     */
    public static function accountData(): array
    {
        $accountData = (array)json_decode(getenv('DATA_ACCOUNT'));

        return [
            [
                $accountData
            ]
        ];
    }
}
