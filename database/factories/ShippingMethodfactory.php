<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ShippingMethod::class, function (Faker $faker) {
    return [
        'name' => 'DHL',
        'price' => 1000
    ];
});
