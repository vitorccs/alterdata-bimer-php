<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use Bimer\AreaType;

class AreaTypeTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = AreaType::class;
    }

    #[DataProvider('areaTypeData')]
    public function testGetByDescription(array $areaType)
    {
        $response = $this->resource::getByDescription($areaType['description']);

        $this->assertGreaterThan(0, count($response));
    }

    #[DataProvider('areaTypeData')]
    public function testGetById(array $areaType)
    {
        $accountInformation = $this->resource::find($areaType['id']);

        $this->assertObjectHasProperty('Identificador', $accountInformation);
    }

    /**
     * Data provider for Area Type Data
     */
    public static function areaTypeData(): array
    {
        $areaType = (array)json_decode(getenv('DATA_AREA_TYPE'));

        return [
            [
                $areaType
            ]
        ];
    }
}
