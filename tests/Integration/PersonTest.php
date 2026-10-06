<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerParameterException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\Person;
use Bimer\Test\Helpers\GeneratorHelper;

class PersonTest extends IntegrationTestCase
{
    private array $personData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = Person::class;

        $this->personData = (array)json_decode(getenv('DATA_PERSON'));
    }

    public function testGetByName()
    {
        $response = $this->resource::getByName('NOME');

        $this->assertIsArray($response);
        $this->assertGreaterThanOrEqual(0, count($response));
    }

    #[DataProvider('addressData')]
    public function testCreatePerson(array $addressData)
    {
        $customer = $this->createCustomer($addressData);

        $this->assertObjectHasProperty('Identificador', $customer);
    }

    public function testGetEmptyCpfCnpj()
    {
        $randomCpf = GeneratorHelper::cpfRandom(false);
        $response = $this->resource::getByCpfCnpj($randomCpf);

        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }

    public function testGetSomeCpfCnpj()
    {
        $response = $this->resource::getByCpfCnpj($this->personData['cpfCnpj']);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    #[DataProvider('addressData')]
    public function testGetById(array $addressData)
    {
        $customer = $this->createCustomer($addressData);
        $person = $this->resource::find($customer->Identificador);
        $this->assertObjectHasProperty('Identificador', $person);
    }

    #[DataProvider('addressData')]
    public function testChangePersonData(array $addressData)
    {
        $customer = $this->createCustomer($addressData);

        $placeholder = 'CHANGE TEST';
        $data = [
            'Nome' => $placeholder,
            'Enderecos' => [
                array_merge($addressData, [
                    'Codigo' => '01',
                    'TipoCadastro' => 'A',
                    'NomeLogradouro' => $placeholder,
                    'Tipos' => [
                        'Principal' => true
                    ]
                ])
            ]
        ];
        $person = $this->resource::update($customer->Identificador, $data);

        $this->assertSame($person->Nome, $placeholder);
        $this->assertSame($person->Enderecos[0]->NomeLogradouro, $placeholder);
    }

    /**
     * Data provider for Address Data
     */
    public static function addressData(): array
    {
        $areaType = (array)json_decode(getenv('DATA_ADDRESS'));

        return [
            [
                $areaType
            ]
        ];
    }

    /**
     * @param array $addressData
     * @return \stdClass
     * @throws BimerApiException
     * @throws BimerParameterException
     * @throws BimerRequestException
     */
    private function createCustomer(array $addressData): \stdClass
    {
        return \Bimer\Customer::create([
            'Nome' => 'Customer #' . rand(),
            'CpfCnpj' => GeneratorHelper::cpfRandom(false),
            'Enderecos' => [
                array_merge($addressData, [
                    'Codigo' => '01',
                    'TipoCadastro' => 'I',
                    'NomeLogradouro' => 'CREATE TEST',
                    'Tipos' => [
                        'Principal' => true
                    ]
                ])
            ]
        ]);
    }
}
