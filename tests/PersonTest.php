<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Exceptions\BimerApiException;

class PersonTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\Person';
        $this->endpoint = 'pessoas';
    }

    /** @test */
    public function it_should_validate_name()
    {
        $this->expectException(BimerApiException::class);

        $response = $this->resource::getByName('a');
    }

    /** @test */
    public function it_should_retrieve_by_name()
    {
        $response = $this->resource::getByName('NOME');

        $this->assertGreaterThanOrEqual(0, count($response));
    }

    /** @test */
    public function it_should_validate_cpf_cnpj()
    {
        $this->expectException(BimerApiException::class);

        $response = $this->resource::getByCpfCnpj('123.456.789-01');
        $this->assertGreaterThanOrEqual(0, count($response));
    }

    /** @test */
    public function it_should_create_a_resource()
    {
        $customer = \Bimer\Customer::create([
            'Nome' => 'Creating Customer #'. rand(),
            'CpfCnpj' => '52693212030'
        ]);

        $this->assertObjectHasAttribute('Identificador', $customer);

        return $customer;
    }

    /** @test */
    public function it_should_retrieve_none_by_cpf_cnpj()
    {
        $response = $this->resource::getByCpfCnpj('537.220.560-12');
        $empty = is_array($response) && count($response) == 0;
        $this->assertTrue($empty);
    }

    /** @test */
    public function it_should_retrieve_some_by_cpf_cnpj()
    {
        $response = $this->resource::getByCpfCnpj('52693212030');
        $some = is_array($response) && count($response) > 0;
        $this->assertTrue($some);
    }

    /**
     * @depends it_should_create_a_resource
     * @test
     */
    public function it_should_find_one_resource($customer)
    {
        $person = $this->resource::find($customer->Identificador);
        $this->assertObjectHasAttribute('Identificador', $person);
    }

    /**
     * @depends it_should_create_a_resource
     * @test
     */
    public function it_should_validate_address($customer)
    {
        $this->expectException(BimerApiException::class);

        $data = [
            'Nome' => 'Changed'
        ];

        $person = $this->resource::update($customer->Identificador, $data);
    }

    /**
     * @depends it_should_create_a_resource
     * @test
     */
    public function it_should_add_address($customer)
    {
        $data = [
            'Nome'          => 'Changed',
            'Enderecos'     => [
                [
                    'TipoCadastro'          => 'I',
                    'CEP'                   => '22060020',
                    'IdentificadorBairro'   => '00A00001R7',
                    'IdentificadorCidade'   => '00A000059E',
                    'NomeLogradouro'        => 'RUA LEOPOLDO MIGUEZ 99/202',
                    'Tipos'                 => [
                        'Principal'  => true
                    ]
                ]
            ]
        ];

        $person = $this->resource::update($customer->Identificador, $data);
        $this->assertSame($person->Nome, strtoupper('Changed'));
    }

    /**
     * @depends it_should_create_a_resource
     * @test
     */
    public function it_should_update_address($customer)
    {
        $data = [
            'Nome'          => 'Changed2',
            'Enderecos'     => [
                [
                    'Codigo'                => '01',
                    'TipoCadastro'          => 'A',
                    'CEP'                   => '22060020',
                    'IdentificadorBairro'   => '00A00001R7',
                    'IdentificadorCidade'   => '00A000059E',
                    'NomeLogradouro'        => 'Changed2',
                    'Tipos'                 => [
                        'Principal'  => true
                    ]
                ]
            ]
        ];

        $person = $this->resource::update($customer->Identificador, $data);
        $this->assertSame($person->Nome, strtoupper('Changed2'));
        $this->assertSame($person->Enderecos[0]->NomeLogradouro, 'Changed2');
    }
}
