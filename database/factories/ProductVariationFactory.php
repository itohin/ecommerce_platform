<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ProductVariation::class, function (Faker $faker) {
    return [
        'product_id' => factory(\App\Models\Product::class),
        'name' => $faker->unique()->name,
        'product_variation_type_id' => factory(\App\Models\ProductVariationType::class)
    ];
});
