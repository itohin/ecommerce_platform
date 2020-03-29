<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
    return [
        'address_id' => factory(\App\Models\Address::class),
        'shipping_method_id' => factory(\App\Models\ShippingMethod::class)
    ];
});
