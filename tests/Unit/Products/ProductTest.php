<?php

namespace Tests\Unit\Products;


use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_it_uses_the_slug_fore_the_route()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    public function test_it_has_many_categories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());

    }

    public function test_it_has_many_variations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());

    }

    public function test_it_returns_the_money_instance_for_the_price()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    public function test_it_returns_a_formatted_price()
    {
        $product = factory(Product::class)->create(['price' => 1000]);

        $this->assertEquals($product->formattedPrice, '£10.00');
    }
}
