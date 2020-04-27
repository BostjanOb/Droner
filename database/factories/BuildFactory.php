<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Build;
use Faker\Generator as Faker;

$factory->define(Build::class, function (Faker $faker) {
    return [
        'repository_id' => fn() => factory(\App\Repository::class)->create()->id,

        'status'   => $faker->randomElement(['started', 'pending', 'success', 'failed']),
        'start_at' => $faker->dateTime,
    ];
});
