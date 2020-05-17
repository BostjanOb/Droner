<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Repository;
use App\User;
use Faker\Generator as Faker;

$factory->define(Repository::class, function (Faker $faker) {
    return [
        'id'         => $faker->unique()->numberBetween(),
        'user_id'    => fn() => factory(User::class)->create()->id,
        'name'       => $faker->name,
        'drone_slug' => $faker->slug,
        'git_link'   => $faker->url,
    ];
});
