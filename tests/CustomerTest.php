<?php
declare(strict_types=1);

namespace Bimer\Test;

class CustomerTest extends ResourceTest
{
		public function setUp()
		{
				$this->resource = 'Bimer\Customer';
				$this->endpoint = 'clientes';
				$this->postData = [
				   'Identificador' => '',
					 'IdentificadorRepresentantePrincipal' => '',
				   'Tipo' => 'F',
				   'Codigo' => '',
				   'CpfCnpj' => '01234567894',
				   'DataNascimento' => '1980-04-26T00:00:00:000Z',
				   'Nome' => 'Nome Completo',
				   'NomeCurto' => 'Nome Curto'
				];
		}

		/** @test */
    public function it_should_retrieve_all_resources()
    {
				// method not implemented on Bimmer API
				$this->expectException(\Exception::class);

				parent::it_should_retrieve_all_resources();
    }

		/** @test */
    public function it_should_not_find_one_resource()
    {
				// method not implemented on Bimmer API
				$this->expectException(\Exception::class);

				parent::it_should_not_find_one_resource();
    }
}
