<?php

namespace Tests\Unit\Products;


use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_uses_the_slug_fore_the_route()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }
}
