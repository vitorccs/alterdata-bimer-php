# alterdata-bimer-php
SDK PHP para a API do Alterdata Bimer

# Exemplos
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';//print_r($person1);
//print_r($person2);

putenv('BIMER_API_URL=http://192.168.0.104:8086/api/');
putenv('BIMER_API_ID=AmigosDoBem.nv');
putenv('BIMER_API_SECRET=ce05e125f5d5cfadc841bfb99970698c');
putenv('BIMER_API_USER=BimerAPI');
putenv('BIMER_API_PWD=Bimer@P&Am1g');

try {
    $characteristics = Bimer\PersonCharacteristic::all();   
    $person1 = Bimer\Person::find('00A0000SQ4');
    $person2 = Bimer\Person::find('NOTFOUND');
} catch (\Exception $e) {
    die("Error: ". $e->getMessage() ."\n");
}

print_r($characteristics);
print_r($person1);
print_r($person2);

die('Success');
```
