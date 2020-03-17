<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductScopingTest extends TestCase
{
    public function test_it_can_scope_by_category()
    {
        $product = factory(Product::class)->create();

        $product->categories()->create(
            $categoty = factory(Category::class)->raw()
        );

        factory(Product::class)->create();

        $this->json('GET', "api/products?category={$categoty['slug']}")
            ->assertJsonCount(1, 'data');

    }
}
