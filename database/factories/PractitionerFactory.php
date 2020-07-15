<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Patient;
use Faker\Generator as Faker;

use App\Models\Practitioner;

$factory->define(Practitioner::class, function (Faker $faker) {
    return [
        // 'user_id' => factory('App\User')->create()->id,
        'patientId' => $faker->text(),
        'family' => $faker->sentence(1),
        'given' => $faker->sentence(1),
        'birthDate' => $faker->date('Y-m-d'),
        'birthSex' => Patient::SEXES[random_int(0, count(Patient::SEXES) - 1)],
        'sex' => Patient::SEXES[random_int(0, count(Patient::SEXES) - 1)],
        'address' => $faker->sentence(1),
        'telecom' => $faker->sentence(1),
        'race' => $faker->sentence(1),
        'ethnicity' => $faker->sentence(1),
        'json' => '{}'
    ];
});
