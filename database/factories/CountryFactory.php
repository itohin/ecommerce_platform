<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Country::class, function (Faker $faker) {
    return [
        'code' => 'GB',
        'name' => 'United Kingdom'
    ];
});
