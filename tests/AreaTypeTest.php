<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\AreaType;

class AreaTypeTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = AreaType::class;

        $this->data     = [
            'description'   => 'RUA',
            'id'            => '00A0000006'
        ];
    }

    /** @test */
    public function it_should_get_by_description()
    {
        $response = $this->resource::getByDescription($this->data['description']);

        $this->assertGreaterThan(0, count($response));

        $this->firstRecord = reset($response);
    }

    /** @test */
    public function it_should_get_by_id()
    {
        $accountInformation = $this->resource::find($this->data['id']);
        $this->assertObjectHasAttribute('Identificador', $accountInformation);
    }
}
