<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    protected $incomeData;

    protected $resource;

    public function testEndpoint()
    {
        $this->assertNotEmpty($this->resource::endpoint());
    }
}
