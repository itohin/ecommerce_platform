<?php

namespace Tests\Feature\Categories;

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
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
