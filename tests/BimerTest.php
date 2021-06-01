<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;
use Bimer\Http\Bimer;

final class BimerTest extends TestCase
{
    public function testSetBimerParameters()
    {
        $envValue = getenv(Bimer::BIMER_API_URL);
        $bimerValue = Bimer::getApiUrl();
        $this->assertEquals($bimerValue, $envValue);

        $envValue = getenv(Bimer::BIMER_API_USER);
        $bimerValue = Bimer::getUsername();
        $this->assertEquals($bimerValue, $envValue);

        $envValue = getenv(Bimer::BIMER_API_PWD);
        $bimerValue = Bimer::getPassword();
        $this->assertEquals($bimerValue, $envValue);

        $envValue = getenv(Bimer::BIMER_API_ID);
        $bimerValue = Bimer::getClientId();
        $this->assertEquals($bimerValue, $envValue);

        $envValue = getenv(Bimer::BIMER_API_SECRET);
        $bimerValue = Bimer::getClientSecret();
        $this->assertEquals($bimerValue, $envValue);

        $envValue = getenv(Bimer::BIMER_API_TIMEOUT);
        $bimerValue = Bimer::getTimeout();
        $this->assertEquals($bimerValue, $envValue);
    }

    /** @test */
    public function setBimerToken()
    {
        $random = (string)rand();
        Bimer::setToken($random);

        $this->assertEquals(Bimer::getToken(), $random);
    }

    protected function tearDown(): void
    {
        Bimer::setToken();
    }
}
