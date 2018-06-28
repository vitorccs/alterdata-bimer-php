<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;
use Bimer\Http\Resource;
use stdClass;

final class ResourceTest extends TestCase
{
		protected $resource;

		public function setUp()
		{
				$this->resource = $this->getMockForAbstractClass(Resource::class);
		}

		/** @test */
		public function it_should_find_one_resource()
		{
				$stdClass = new stdClass;
				$this->resource->apiRequester->method('request')->willReturn($stdClass);
				$response = $this->resource->retrieve(1);
				$this->assertSame($response, $stdClass);
		}
}
