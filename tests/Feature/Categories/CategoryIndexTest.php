<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_collections_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                'slug' => $category->slug
            ]);
        });
    }

    public function test_it_returns_ordered_categories()
    {
        $category = factory(Category::class)->create(['order' => 2]);
        $secondCategory = factory(Category::class)->create(['order' => 1]);

        $this->json('GET', 'api/categories')
            ->assertSeeInOrder([
                $secondCategory->slug, $category->slug
            ]);

    }

    public function test_it_returns_only_parent_categories()
    {
        $category = factory(Category::class)->create();

        $category->children()->create(
            factory(Category::class)->raw()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');

    }
}
