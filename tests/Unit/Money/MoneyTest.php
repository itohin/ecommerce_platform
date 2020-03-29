<?php

namespace Tests\Unit\Money;


use App\Cart\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    public function test_it_can_get_a_raw_amount()
    {
        $money = new Money(1000);

        $this->assertEquals($money->amount(), 1000);
    }

    public function test_it_can_get_a_formatted_amount()
    {
        $money = new Money(1000);

        $this->assertEquals($money->formatted(), '£10.00');
    }

    public function test_it_can_add_upp()
    {
        $money = new Money(1000);

        $money->add(new Money(1000));

        $this->assertEquals($money->amount(), 2000);
    }

    public function test_it_can_return_the_underlying_instance()
    {
        $money = new Money(1000);

        $this->assertInstanceOf(\Money\Money::class, $money->instance());
    }
}
