<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\AccountInformation;

class AccountInformationTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = AccountInformation::class;

        $this->data = [
            'description' => 'aa',
            'id' => '00A00000AA',
        ];
    }

    /**
     * @test
     */
    public function it_should_get_by_description()
    {
        $response = $this->resource::getByDescription($this->data['description']);

        $this->assertGreaterThan(0, count($response));
    }

    /**
     * @test
     */
    public function it_should_get_by_id()
    {
        $accountInformation = $this->resource::find($this->data['id']);
        $this->assertObjectHasAttribute('Identificador', $accountInformation);
    }
}