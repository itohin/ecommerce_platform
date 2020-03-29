<?php

namespace Tests\Unit\Models\Orders;


use App\Models\Address;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_it_has_a_default_status_pending()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)
        ]);

        $this->assertEquals($order->status, Order::PENDING);
    }

    public function test_it_belongs_to_a_user()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)
        ]);

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_it_belongs_to_an_address()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)
        ]);

        $this->assertInstanceOf(Address::class, $order->address);
    }

    public function test_it_belongs_to_the_shipping_metho()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)
        ]);

        $this->assertInstanceOf(ShippingMethod::class, $order->shippingMethod);
    }
}
