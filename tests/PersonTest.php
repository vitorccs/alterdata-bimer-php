<?php
declare(strict_types=1);

namespace Bimer\Test;

use Bimer\Http\Api;
use Bimer\Customer;

final class PersonTest extends ResourceTest
{
		public function setUp()
		{
				$this->resource = $this->getMockForAbstractClass(Person::class);
		}

		/** @test */
		public function it_should_have_an_endpoint()
		{
				$this->assertSame($this->resource->endpoint(), 'pessoas');
		}
}
