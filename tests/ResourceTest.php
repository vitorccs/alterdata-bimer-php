<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    protected $data;

    protected $resource;

    public function it_should_have_an_endpoint()
    {
        $this->assertNotEmpty($this->resource::endpoint());
    }
}
