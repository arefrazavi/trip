<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RewardsProgram;
use Faker\Generator as Faker;

$factory->define(RewardsProgram::class, function (Faker $faker) {
    return [
        'name' => $faker->name . ' Reward Program'
    ];
});
