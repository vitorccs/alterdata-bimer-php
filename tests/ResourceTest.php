<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;
use stdClass;

class ResourceTest extends TestCase
{
		/** @test */
		public function it_should_have_an_endpoint()
		{
				$this->assertSame($this->resource::endpoint(), $this->endpoint);
		}

		/** @test */
    public function it_should_retrieve_all_resources()
    {
        $response = $this->resource::all();
				$this->assertGreaterThan(0, count($response));
    }

		/**
     * @depends it_should_retrieve_all_resources
     */
		public function it_should_find_one_resource()
		{
				$collection = $this->resource::all();
				$first = reset($collection);

				$response = $this->resource::find($first->Identificador);
				$this->assertObjectHasAttribute('Identificador', $response);
		}

		/** @test */
		public function it_should_not_find_one_resource()
		{
				$response = $this->resource::find('INVALID');
				$this->assertSame(null, $response);
		}

		/** @test */
    public function it_should_not_create_a_resource()
    {
				// invalid data request
				$this->expectException(\Exception::class);

        $this->resource::create([]);
    }

		/** @test */
    public function it_should_create_a_resource()
    {
        $this->postData = $this->resource::create($this->postData);
				$this->assertObjectHasAttribute('Identificador', $this->postData);
    }

		/**
     * @depends it_should_create_a_resource
     */
    public function it_should_update_a_resource()
    {
				$this->postData['Nome'] = 'Alterado';

        $response = $this->resource::update($this->postData['Identificador'], $this->postData);
				$this->assertObjectHasAttribute('Identificador', $response);

				$this->assertSame($this->postData['Nome'], 'Alterado');
    }
}
