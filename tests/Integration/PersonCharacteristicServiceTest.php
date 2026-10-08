<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use Bimer\PersonCharacteristicService;

class PersonCharacteristicServiceTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = new PersonCharacteristicService();
    }

    public function testGetArray(): void
    {
        $response = $this->resource->all();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, count($response));
    }
}
