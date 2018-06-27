<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

putenv('BIMER_API_URL=http://192.168.0.104:8086/api/');
putenv('BIMER_API_ID=AmigosDoBem.nv');
putenv('BIMER_API_SECRET=ce05e125f5d5cfadc841bfb99970698c');
putenv('BIMER_API_USER=BimerAPI');
putenv('BIMER_API_PWD=Bimer@P&Am1g');

try {
		//$characteristics = Bimer\PersonCharacteristic::all();
		//$person1 = Bimer\Person::find('00A0000SQ4');
		//$person2 = Bimer\Person::find('NOTFOUND');
		/*
		$person3 = Bimer\Customer::create([
		   'Identificador' => '',
			 'IdentificadorRepresentantePrincipal' => '',
		   'Tipo' => 'F',
		   'Codigo' => '',
		   'CpfCnpj' => '01234567894',
		   'DataNascimento' => '1980-04-26T00:00:00:000Z',
		   'Nome' => 'Nome Completo',
		   'NomeCurto' => 'Nome Curto',
		   'Enderecos' => [
			    [
			       'CEP' => '22060020',
			       'CodigoSuframa' => '',
			       'Complemento' => '',
			       'IdentificadorBairro' => '00A00001R7',
			       'IdentificadorCidade' => '00A000059E',
			       'IdentificadorTipoLogradouro' => '',
			       'InscricaoEstadual' => '',
			       'NomeLogradouro' => 'RUA LEOPOLDO MIGUEZ 99/202',
			       'NumeroLogradouro' => '',
			       'Observacao' => '11020258',
			       'PessoasContato' => [
			        [
			           'ContatoPrincipal' => true,
			           'Email' => 'email@globocom',
			           'Identificador' => '',
			           'Nome' => 'Pessoa de contato inserida pela API',
			           'PaginaInternet' => '',
			           'TipoCadastro' => 'I',
			           'TelefoneCelular' => '(0021)99999-9999',
			           'TelefoneFixo' => '(0021)11111-111',
			        ]
			      ],
			       'SiglaUnidadeFederativa' => 'RJ',
			       'TipoCadastro' => 'I',
			       'Tipos' => [
			         'Cobranca' => true,
			         'Comercial' => true,
			         'Correspondencia' => true,
			         'Entrega' => true,
			         'Principal' => true,
			         'Residencial' => true,
			      	],
			       'Codigo' => '01',
			    ]
		  	]
		]);
		*/
} catch (\Exception $e) {
		die("Error: ". $e->getMessage() ."\n");
}

//print_r($characteristics);
//print_r($person1);
//print_r($person2);
//print_r($person3);

die("Success \n");
?>
