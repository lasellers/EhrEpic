<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        // 'user_id' => factory('App\User')->create()->id,
        'patientId' => $faker->text(),
        'family' => $faker->sentence(1),
        'given' => $faker->sentence(1),
        'json' => '{}'
    ];
});
