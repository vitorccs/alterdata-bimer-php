<?php
declare(strict_types=1);

namespace Bimer\Test;

class AccountInformationTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\AccountInformation';
        $this->endpoint = 'naturezaLancamento';

        $this->data     = [
            'description'   => 'a',
            'id'            => '00A00000AA',
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
