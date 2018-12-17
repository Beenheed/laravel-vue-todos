<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Todo::class, function (Faker $faker) {
    return [
        'title'         => $faker->sentence,
        'description'   => $faker->paragraph,
        'done'   		=> $faker->boolean,
        'due_date'      => $faker->date('Y-m-d H:i:s','now'),
    ];
});
