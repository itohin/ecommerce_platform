<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_many_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->create(
            factory(Category::class)->raw()
        );

        $this->assertInstanceOf(Category::class, $category->children->first());
    }

    public function test_it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->children()->create(
            factory(Category::class)->raw()
        );

        $this->assertEquals(1, Category::parents()->count());
    }

    public function test_it_is_orderable()
    {
        $category = factory(Category::class)->create(['order' => 2]);
        $secondCategory = factory(Category::class)->create(['order' => 1]);

        $this->assertEquals($secondCategory->name, Category::ordered()->first()->name);
    }
}
