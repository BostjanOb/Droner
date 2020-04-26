<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Build;
use Faker\Generator as Faker;

$factory->define(Build::class, function (Faker $faker) {
    return [
        'status'   => $faker->randomElement(['started', 'pending', 'success', 'failed']),
        'start_at' => $faker->dateTime,
    ];
});
