<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookingGoal;
use App\Models\Agency;
use Faker\Generator as Faker;

$factory->define(BookingGoal::class, function (Faker $faker) {
    return [
        'agency_id' => function () {
            return factory(Agency::class)->create()->id;
        },
        'year' => $faker->year,
        'target' => $faker->biasedNumberBetween(1000, 100000000),
        'achievement' => $faker->biasedNumberBetween(1000, 100000000)
    ];
});
