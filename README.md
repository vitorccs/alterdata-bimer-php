# Alterdata Bimer - SDK PHP
SDK PHP para a API do Alterdata Bimer


## Descrição
SDK em PHP para integração com os serviços de API do ERP Alterdata Bimer.
Documentação da API Alterdata Bimer: https://bimer-api-docs.alterdata.com.br.


## Instalação
Via Composer
```bash
composer require vitorccs/alterdata-bimer-php
```

## Métodos disponíveis
All: Buscar objetos. Retorna array de objetos.
```php
$person = (new \Bimer\PersonCharacteristicService())->all();
```

Find: Encontrar objetos por ID. Retorna objeto.
```php
$person = (new \Bimer\PersonService())->find($strId);
```

Create: Criar novo objeto. Retorna objeto criado.
```php
$customer = (new \Bimer\CustomerService())->create($arrayData);
```

Update: Atualiza objeto. Retorna objeto atualizado.
```php
$person = (new \Bimer\PersonService())->update($strId, $arrayData);
```

## Métodos específicos por recurso
```php
$postalCode = (new \Bimer\PostalCodeService())->getByCode('03943000');
$people = (new \Bimer\PersonService())->getByName('maria', true);
$people = (new \Bimer\PersonService())->getByCpfCnpj('123.456.789-01');
```

## Variáveis de ambiente
Os seguintes parâmetros devem ser informados:

| Parâmetro         | Obrigatório | Descrição                                             |
|-------------------|-------------|-------------------------------------------------------|
| BIMER_API_URL     | Sim         | URL da API                                            |
| BIMER_API_ID      | Sim         | ID do cliente                                         |
| BIMER_API_SECRET  | Sim         | Segredo do cliente                                    |
| BIMER_API_USER    | Sim         | Usuário                                               |
| BIMER_API_PWD     | Sim         | Senha                                                 |
| BIMER_API_TIMEOUT | Não         | Timeout em segundos da conexão com a API (padrão: 30) |


## Autenticação
* Não é necessário codificar a variável `BIMER_API_PWD` com MD5, a SDK fará isso automaticamente.
* Não é necessário autenticar manualmente, O SDK irá autenticar e obter um token automaticamente.
* Cada processo PHP possuirá o seu próprio token de autenticação, sendo reaproveitado até o término da execução do script PHP. Caso esteja executando o PHP sem timeout (ex: CLI), o token será trocado a cada 10 minutos. Desta forma, evitamos sobrecarga no servidor da API.


## Exemplo de implementação

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';

putenv('BIMER_API_URL=http://path:8086/api/');
putenv('BIMER_API_ID=client_id');
putenv('BIMER_API_SECRET=client_secret');
putenv('BIMER_API_USER=username');
putenv('BIMER_API_PWD=password');

use Bimer\CustomerService;
use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerRequestException;
use Bimer\PersonService;
use Bimer\PersonCharacteristicService;

try {
    // define serviços
    $personCharacteristicService = new PersonCharacteristicService();
    $personService = new PersonService();
    $customerService = new CustomerService();

    // obter lista de Características
    $characteristics = $personCharacteristicService->all();
    print_r($characteristics);

    // encontrar Pessoa por ID
    $person = $personService->find('00A0000SQ4');
    print_r($person);

    // atualizar Pessoa por ID
    $person = $personService->update('00A0000SQ4', [
        'Nome' => 'Nome Completo2',
        'NomeCurto' => 'Nome Curto2'
    ]);
    print_r($person);

    // encontrar pessoa por nome
    $people = $personService->getByName('NOME', true);
    print_r($people);

    // encontrar pessoa por CPF ou CNPJ
    $people = $personService->getByCpfCnpj('123.456.789-01');
    print_r($people);

    // criar Cliente
    $customer = $customerService->create([
        'Tipo' => 'F',
        'CpfCnpj' => '01234567894',
        'DataNascimento' => '1980-04-26T00:00:00:000Z',
        'Nome' => 'Nome Completo',
        'NomeCurto' => 'Nome Curto'
    ]);
    print_r($customer);

} catch (BimerApiException $e) { // erros retornados pela API Bimer
    echo sprintf("BimerApiException %s (%s)", $e->getMessage(), $e->getErrorCode());
} catch (BimerRequestException $e) { // erros de servidor (erros HTTP 4xx e 5xx)
    echo sprintf("BimerRequestException %s (%s)", $e->getMessage(), $e->getErrorCode());
} catch (\Exception $e) { // demais erros
    echo $e->getMessage();
}
```


## Métodos implementados
* CEP (PostalCodeService)
* Cliente (CustomerService)
* NaturezaLancamento (AccountInformationService)
* Pessoa (PersonService)
* PessoaCaracteristica (PersonCharacteristicService)
* Titulos a Receber (IncomeService)
* TiposLogradouro (AreaTypeService)

... por favor, contribua com mais implementações


## Testes
Caso queira contribuir, por favor, implementar testes em PHPUnit.

Para executar:
1) Faça uma cópia de `phpunit.xml.dist` em `phpunit.xml` na raíz do projeto
2) Altere os parâmetros ENV com os dados de seu acesso
3) Execute o comando abaixo no terminal dentro da pasta deste projeto:

```bash
composer test
```

Os testes estão separados em `tests/Unit` (não acessam a API) e `tests/Integration` (acessam a API). Os testes de integração são ignorados automaticamente enquanto `BIMER_API_URL` não contiver uma URL válida. Também é possível executar cada suíte separadamente:

```bash
composer test:unit         # somente testes que não acessam a API
composer test:integration  # somente testes que acessam a API
```
