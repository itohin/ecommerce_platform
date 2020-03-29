<?php

namespace Tests\Unit\Models\ShippingMethods;


use App\Cart\Money;
use App\Models\Country;
use App\Models\ShippingMethod;
use Tests\TestCase;

class ShippingMethodTest extends TestCase
{
    public function test_it_belongs_to_many_countries()
    {
        $method = factory(ShippingMethod::class)->create();

        $method->countries()->sync(
            factory(Country::class)->create()
        );

        $this->assertInstanceOf(Country::class, $method->countries->first());
    }

    public function test_it_returns_formatted_price()
    {
        $method = factory(ShippingMethod::class)->create([
            'price' => 0
        ]);

        $this->assertEquals($method->formattedprice, '£0.00');
    }

    public function test_it_returns_a_money_instance_for_the_price()
    {
        $method = factory(ShippingMethod::class)->create();

        $this->assertInstanceOf(Money::class, $method->price);
    }
}
