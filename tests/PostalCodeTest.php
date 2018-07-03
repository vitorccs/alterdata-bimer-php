<?php
declare(strict_types=1);

namespace Bimer\Test;

class PostalCodeTest extends ResourceTest
{
    public function setUp()
    {
        $this->resource = 'Bimer\PostalCode';
        $this->endpoint = 'ceps';
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
    public function it_should_not_find_one_resource()
    {
        // method not implemented on Bimmer API
        $this->expectException(\Exception::class);

        parent::it_should_not_find_one_resource();
    }

    /** @test */
    public function it_should_create_a_resource()
    {
        // method not implemented on Bimmer API
        $this->expectException(\Exception::class);

        parent::it_should_create_a_resource();
    }

    /** @test */
    public function it_should_get_by_code()
    {
        $response = $this->resource::getByCode('03912010');
        $this->assertGreaterThan(0, count($response));
    }
}
