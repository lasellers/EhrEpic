<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Procedure;
use Faker\Generator as Faker;

$factory->define(Procedure::class, function (Faker $faker) {
    return [
        // 'user_id' => factory('App\User')->create()->id,
        'patientId' => $faker->text(),
        'family' => $faker->sentence(1),
        'given' => $faker->sentence(1),
        'json' => '{}'
    ];
});
