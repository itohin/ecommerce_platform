<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Stock::class, function (Faker $faker) {
    return [
        'quantity' => 1
    ];
});
