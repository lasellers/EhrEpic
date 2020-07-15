<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Models\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        // 'user_id' => factory('App\User')->create()->id,
        'patient_id' => $faker->text(),
        'practitioner_id' => $faker->sentence(1),
        'comment' => $faker->sentence(20),
        'created_at' => $faker->date('Y-m-d'),
        'updated_at' => $faker->date('Y-m-d')
    ];
});
