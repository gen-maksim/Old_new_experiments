<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TrainingApplication;
use Faker\Generator as Faker;

$factory->define(TrainingApplication::class, function (Faker $faker) {
    return [
        'training_id' => factory(\App\Training::class)->create(),
        'user_id' => factory(\App\User::class)->create(),
        'comment' => $faker->sentence,
    ];
});
