# Alterdata Bimer - SDK PHP
SDK PHP para a API do Alterdata Bimer


## Descrição
SDK em PHP para integração com os serviços de API do ERP Alterdata Bimer.
Documentação da API Alterdata Bimer: https://bimersandbox.alterdata.com.br/#/.


## Instalação
Via Composer
```bash
composer require vitorccs/alterdata-bimer-php
```


## Métodos disponíveis
All: Buscar objetos. Retorna array de objetos.
```php
$person = Bimer\PersonCharacteristic::all();
```

Find: Encontrar objetos por ID. Retorna objeto.
```php
$person = Bimer\Person::find($strId);
```

Create - Criar novo objeto. Retorna objeto criado.
```php
$customer = Bimer\Customer::create($arrayData);
```

Update - Atualiza objeto. Retorna objeto atualizado.
```php
$person = Bimer\Person::update($strId, $arrayData);
```

## Métodos específicos por recurso
```php
$postalCode = Bimer\PostalCode::getByCode('03943000');
$people = Bimer\Person::getByName('maria', true);
$people = Bimer\Person::getByCpfCnpj('123.456.789-01');
```

## Variáveis de ambiente
Os seguintes parâmetros devem ser informados:
* BIMER_API_URL (URL da API)
* BIMER_API_ID (ID do cliente)
* BIMER_API_SECRET (Segredo do cliente)
* BIMER_API_USER (Usuário)
* BIMER_API_PWD (Senha)
* BIMER_API_TIMEOUT (Opcional, padrão 30. Timeout em segundos para estabelecer conexão com a API)


## Autenticação
Não é necessário codificar a variável BIMER_API_PWD com MD5, a SDK fará isso automaticamente.

Não é necessário autenticar manualmente, O SDK irá autenticar e obter um token automaticamente.

Cada processo PHP possuirá o seu próprio token de autenticação, sendo reaproveitado até o término da execução do script PHP. Caso esteja executando o PHP sem timeout (ex: CLI), o token será trocado a cada 10 minutos. Desta forma, evitamos sobrecarga no servidor da API.


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

use Bimer\Exceptions\BimerApiException;
use Bimer\Exceptions\BimerRequestException;

try {
    $characteristics = Bimer\PersonCharacteristic::all();
    print_r($characteristics); // array of objects

    $person = Bimer\Person::find('00A0000SQ4');
    print_r($person); // object

    $person = Bimer\Person::update('00A0000SQ4', [
       'Nome' => 'Nome Completo2',
       'NomeCurto' => 'Nome Curto2'
    ]);
    print_r($person); // object

    $people = Bimer\Person::getByName('NOME', true);
    print_r($people); // array of objects

    $people = Bimer\Person::getByCpfCnpj('123.456.789-01');
    print_r($people); // array of objects

    $customer = Bimer\Customer::create([
        'Identificador' => '',
        'IdentificadorRepresentantePrincipal' => '',
        'Tipo' => 'F',
        'Codigo' => '',
        'CpfCnpj' => '01234567894',
        'DataNascimento' => '1980-04-26T00:00:00:000Z',
        'Nome' => 'Nome Completo',
        'NomeCurto' => 'Nome Curto'
    ]);
    print_r($customer); // object

} catch (BimerApiException $e) { // erros retornados pela API Bimer
    echo sprintf("%s (%s)", $e->getMessage(), $e->getErrorCode());
} catch (BimerRequestException $e) { // erros de servidor (erros HTTP 4xx e 5xx)
    echo sprintf("%s (%s)", $e->getMessage(), $e->getErrorCode());
} catch (\Exception $e) { // demais erros
    echo $e->getMessage();
}
```


## Métodos implementados
* CEP (PostalCode)
* Cliente (Customer)
* Pessoa (Person)
* PessoaCaracteristica (PersonCharacteristic)
* Titulos a Receber (Income)

... por favor, contribua com mais implementações


## Testes
Caso queira contribuir, por favor, implementar testes de unidade em PHPUnit.

Para executar:
1) Faça uma cópia de phpunit.xml.dist em phpunit.xml na raíz do projeto
2) Altere os parâmtros ENV com os dados de seu acesso
3) Execute o comando abaixo no terminal dentro da pasta deste projeto:

```bash
composer test
```
