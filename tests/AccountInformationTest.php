<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\AccountInformation;

class AccountInformationTest extends ResourceTest
{
    public function setUp(): void
    {
        $this->resource = AccountInformation::class;
    }

    /**
     * @dataProvider accountData
     */
    public function testGetByDescription(array $accountData)
    {
        $response = $this->resource::getByDescription($accountData['description']);

        $this->assertGreaterThan(0, count($response));
    }

    /**
     * @dataProvider accountData
     */
    public function testGetById(array $accountData)
    {
        $accountInformation = $this->resource::find($accountData['id']);
        $this->assertObjectHasAttribute('Identificador', $accountInformation);
    }

    /**
     * Data provider for Account Data
     */
    public function accountData(): array
    {
        $accountData = (array)json_decode(getenv('DATA_ACCOUNT'));

        return [
            [
                $accountData
            ]
        ];
    }
}
