<?php
declare(strict_types=1);

namespace Bimer\Test;

use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    public function it_should_have_an_endpoint()
    {
        $this->assertSame($this->resource::endpoint(), $this->endpoint);
    }
}
