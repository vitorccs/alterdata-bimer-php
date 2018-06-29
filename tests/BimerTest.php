<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;
use Bimer\Http\Bimer;

final class BimerTest extends TestCase
{
    /** @test */
    public function it_should_get_vars_from_environment()
    {
        $envValue        = getenv(Bimer::BIMER_API_URL);
        $bimmerValue    = Bimer::getApiUrl();
        $this->assertEquals($bimmerValue, $envValue);

        $envValue        = getenv(Bimer::BIMER_API_USER);
        $bimmerValue    = Bimer::getUsername();
        $this->assertEquals($bimmerValue, $envValue);

        $envValue        = getenv(Bimer::BIMER_API_PWD);
        $bimmerValue    = Bimer::getPassword();
        $this->assertEquals($bimmerValue, $envValue);

        $envValue        = getenv(Bimer::BIMER_API_ID);
        $bimmerValue    = Bimer::getClientId();
        $this->assertEquals($bimmerValue, $envValue);

        $envValue        = getenv(Bimer::BIMER_API_SECRET);
        $bimmerValue    = Bimer::getClientSecret();
        $this->assertEquals($bimmerValue, $envValue);

        $envValue        = getenv(Bimer::BIMER_API_TIMEOUT);
        $bimmerValue    = Bimer::getTimeout();
        $this->assertEquals($bimmerValue, $envValue);
    }

    /** @test */
    public function it_should_set_token()
    {
        $random = rand();
        Bimer::setToken($random);
        $value = Bimer::getToken();
        $this->assertEquals($value, $random);

        Bimer::setToken(null);
    }
}
