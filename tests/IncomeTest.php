<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Income;

class IncomeTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = Income::class;

        $this->data     = [
        	'CodigoEmpresa'                => '1',
        	'IdentificadorPessoa'          => '00A000000A',
        	'IdentificadorFormaPagamento'  => '00A0000001',
        	'CodigoEnderecoCobranca'       => '01',
        	'ValorTitulo'                  => 100
        ];
    }

    /** @test */
    public function it_should_create_a_resource()
    {
        $incomeId = Income::create($this->data);

        $this->assertTrue(strlen($incomeId) > 1);

        return $incomeId;
    }

    /**
     * @depends it_should_create_a_resource
     * @test
     */
    public function it_should_retrieve_resource($incomeId)
    {
        $income = $this->resource::find($incomeId);
        $this->assertObjectHasAttribute('Identificador', $income);
    }
}
