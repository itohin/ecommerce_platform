<?php

namespace Tests\Unit\Models\Users;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create(['password' => $password = 'password']);

        $this->assertNotEquals($user->password, $password);
    }

    public function test_it_has_many_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    public function test_it_has_quantity_for_each_cart_item()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create(), [
                'quantity' => $quantity = 5
            ]
        );

        $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }

    public function test_it_has_many_addressses()
    {
        $user = factory(User::class)->create();

        $user->addresses()->save(
            factory(Address::class)->make()
        );

        $this->assertInstanceOf(Address::class, $user->addresses->first());
    }

    public function test_it_has_many_orders()
    {
        $user = factory(User::class)->create();

        $user->orders()->save(
            factory(Order::class)->make()
        );

        $this->assertInstanceOf(Order::class, $user->orders->first());
    }

    public function test_it_has_many_payment_methods()
    {
        $user = factory(User::class)->create();

        $user->paymentMethods()->save(
            factory(PaymentMethod::class)->make()
        );

        $this->assertInstanceOf(PaymentMethod::class, $user->paymentMethods->first());
    }
}
