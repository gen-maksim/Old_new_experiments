<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Training;
use App\User;
use Faker\Generator as Faker;

$factory->define(Training::class, function (Faker $faker) {
    return [
        'owner_id' => factory(User::class)->create()->id,
        'duration_in_mins' => 240,
        'start_datetime' => \Carbon\Carbon::now()->addDays(10),
    ];
});
