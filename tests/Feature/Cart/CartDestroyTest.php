<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartDestroyTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $this->json('DELETE', 'api/cart/1')
            ->assertStatus(401);
    }

    public function test_it_product_cant_be_found()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'DELETE', 'api/cart/1')
            ->assertStatus(404);
    }

    public function test_it_deletes_an_item_from_the_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = factory(ProductVariation::class)->create()
        );

        $this->jsonAs($user, 'DELETE', "api/cart/{$product->id}");

        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id
        ]);
    }
}
