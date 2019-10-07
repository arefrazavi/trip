<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ServiceExcellence;
use App\Models\Agency;
use Faker\Generator as Faker;

$factory->define(ServiceExcellence::class, function (Faker $faker) {
    return [
        'agency_id' => function () {
            return factory(Agency::class)->create()->id;
        },
        'month' => $faker->month,
        'year' => $faker->year,
        'achieved' => $faker->boolean
    ];
});
