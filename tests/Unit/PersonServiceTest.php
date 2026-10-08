<?php
declare(strict_types=1);

namespace Bimer\Test\Unit;

use Bimer\Exceptions\BimerApiException;
use Bimer\PersonService;
use PHPUnit\Framework\TestCase;

class PersonServiceTest extends TestCase
{
    public function testValidateName(): void
    {
        $this->expectException(BimerApiException::class);

        (new PersonService())->getByName('a');
    }

    public function testValidateCpfCnpj(): void
    {
        $this->expectException(BimerApiException::class);

        (new PersonService())->getByCpfCnpj('123.456.789-01');
    }
}
