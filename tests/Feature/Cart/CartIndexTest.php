<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartIndexTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $this->json('GET', 'api/cart')
            ->assertStatus(401);
    }

    public function test_it_shows_products_in_users_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = factory(ProductVariation::class)->create()
        );

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_shows_if_the_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'empty' => true
            ]);
    }

    public function test_it_shows_a_formatted_subtotal()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '£0.00'
            ]);
    }

    public function test_it_shows_a_formatted_total()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '£0.00'
            ]);
    }

    public function test_it_syncs_the_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(), [
                'quantity' => 2
            ]
        );

        $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'changed' => true
            ]);
    }

    public function test_it_shows_a_formatted_total_with_shipping()
    {
        $user = factory(User::class)->create();

        $shipping = factory(ShippingMethod::class)->create([
            'price' => 1000
        ]);

        $this->jsonAs($user, 'GET', "api/cart?shipping_method_id={$shipping->id}")
            ->assertJsonFragment([
                'subtotal' => '£0.00'
            ]);
    }
}
