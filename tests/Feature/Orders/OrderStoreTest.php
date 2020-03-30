<?php

namespace Tests\Feature\Orders;

use App\Models\Address;
use App\Models\Country;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStoreTest extends TestCase
{
    public function test_it_fails_if_not_authenticated()
    {
        $this->json('POST', 'api/orders')
            ->assertStatus(401);
    }

    public function test_it_requires_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders')
            ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_an_address_that_exists()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'address_id' => 1
        ])
            ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_an_address_that_belongs_to_user()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'address_id' => $address->id,
            'user_id' => $user->id
        ])
            ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_a_shipping_method()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders')
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    public function test_it_requires_a_shipping_method_that_exists()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method_id' => 1
        ])
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    public function test_it_requires_a_shipping_method_valid_for_a_given_address()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => $user->id,
            'country_id' => factory(Country::class)
        ]);

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method_id' => factory(ShippingMethod::class),
            'address_id' => $address->id
        ])
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    public function test_it_can_create_an_order()
    {
        $user = factory(User::class)->create();

        [$address, $shipping] = $this->orderDependencies($user);

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method_id' => $shipping->id,
            'address_id' => $address->id,
            'subtotal' => 5000
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'address_id' => $address->id,
            'shipping_method_id' => $shipping->id
        ]);
    }

    public function test_it_fails_if_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync([
            $product = ($this->productWithStock())->id, [
                'quantity' => 0
            ]
        ]);

        [$address, $shipping] = $this->orderDependencies($user);

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method_id' => $shipping->id,
            'address_id' => $address->id,
            'subtotal' => 5000
        ])->assertStatus(400);
    }

    public function test_it_attaches_the_product_to_the_order()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        [$address, $shipping] = $this->orderDependencies($user);

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method_id' => $shipping->id,
            'address_id' => $address->id,
            'subtotal' => 5000
        ]);

        $this->assertDatabaseHas('product_variation_order', [
            'product_variation_id' => $product->id
        ]);
    }

    protected function productWithStock()
    {
        $product = factory(ProductVariation::class)->create();

        factory(Stock::class)->create([
            'product_variation_id' => $product->id
        ]);

        return $product;
    }

    protected function orderDependencies(User $user)
    {
        $address = factory(Address::class)->create([
            'user_id' => $user->id,
        ]);

        $shipping = factory(ShippingMethod::class)->create();

        $shipping->countries()->attach($address->country);

        return [$address, $shipping];
    }
}
