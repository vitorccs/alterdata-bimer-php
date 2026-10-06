<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\Exceptions\BimerApiException;
use Bimer\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testValidateName()
    {
        $this->expectException(BimerApiException::class);

        Person::getByName('a');
    }

    public function testValidateCpfCnpj()
    {
        $this->expectException(BimerApiException::class);

        Person::getByCpfCnpj('123.456.789-01');
    }
}
