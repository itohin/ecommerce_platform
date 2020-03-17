<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => \Illuminate\Support\Str::slug($name),
        'description' => $faker->sentence(5),
        'price' => 1000
    ];
});
