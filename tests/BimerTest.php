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
				$random = rand();
				putenv(Bimer::BIMER_API_URL . '=' . $random);
				$value = Bimer::getApiUrl();
				$this->assertEquals($value, $random);

				$random = rand();
				putenv(Bimer::BIMER_API_USER . '=' . $random);
				$value = Bimer::getUsername();
				$this->assertEquals($value, $random);

				$random = rand();
				putenv(Bimer::BIMER_API_PWD . '=' . $random);
				$value = Bimer::getPassword();
				$this->assertEquals($value, $random);

				$random = rand();
				putenv(Bimer::BIMER_API_ID . '=' . $random);
				$value = Bimer::getClientId();
				$this->assertEquals($value, $random);

				$random = rand();
				putenv(Bimer::BIMER_API_SECRET . '=' . $random);
				$value = Bimer::getClientSecret();
				$this->assertEquals($value, $random);

				$random = rand();
				putenv(Bimer::BIMER_API_TIMEOUT . '=' . $random);
				$value = Bimer::getTimeout();
				$this->assertEquals($value, $random);
		}

		/** @test */
		public function it_should_set_token()
		{
				$random = rand();
				Bimer::setToken($random);
				$value = Bimer::getToken();
				$this->assertEquals($value, $random);
		}
}
