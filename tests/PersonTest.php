<?php
declare(strict_types=1);

namespace Bimer\Test;

class PersonTest extends ResourceTest
{
		public function setUp()
		{
				$this->resource = 'Bimer\Person';
				$this->endpoint = 'pessoas';
				$this->data = [];
		}

		/** @test */
    public function it_should_retrieve_all_resources()
    {
				// method not implemented on Bimmer API
				$this->expectException(\Exception::class);

				parent::it_should_retrieve_all_resources();
    }

		/** @test */
    public function it_should_create_a_resource()
    {
				// method not implemented on Bimmer API
				$this->expectException(\Exception::class);

				parent::it_should_create_a_resource();
    }
}
