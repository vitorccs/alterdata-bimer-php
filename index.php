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
		/*
		$characteristics = Bimer\PersonCharacteristic::all();

		$person1 = Bimer\Person::find('00A0000SQ4');
		$person2 = Bimer\Person::find('NOTFOUND');
		$person1 = Bimer\Person::update('00A0000SQ4', [
		   'Nome' => 'Nome Completo25',
		   'NomeCurto' => 'Nome Curto25'
		]);
		/*

		$customer1 = Bimer\Customer::create([
		   'Identificador' => '',
			 'IdentificadorRepresentantePrincipal' => '',
		   'Tipo' => 'F',
		   'Codigo' => '',
		   'CpfCnpj' => '01234567894',
		   'DataNascimento' => '1980-04-26T00:00:00:000Z',
		   'Nome' => 'Nome Completo',
		   'NomeCurto' => 'Nome Curto'
		]);
		*/
		$customer1 = Bimer\Customer::create([]);
} catch (\Exception $e) {
		die("Error: ". $e->getMessage() ."\n");
}

//print_r($characteristics); // array of objects
//print_r($person1); // object
//var_dump($person2); // NULL
//print_r($customer1); // object

die("Success \n");
?>
