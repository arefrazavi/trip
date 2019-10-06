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

$fakeServiceExcellencesData = [
    'Agency 1' => [
        [
            'year' => 2019,
            'month' => 7,
            'achieved' => true
        ],
        [
            'year' => 2019,
            'month' => 8,
            'achieved' => true
        ],
        [
            'year' => 2019,
            'month' => 9,
            'achieved' => false
        ]
    ],
    'Agency 2' => [
        [
            'year' => 2019,
            'month' => 7,
            'achieved' => false
        ],
        [
            'year' => 2019,
            'month' => 8,
            'achieved' => true
        ],
        [
            'year' => 2019,
            'month' => 9,
            'achieved' => true
        ]
    ],
    'Agency 3' => [
        [
            'year' => 2019,
            'month' => 7,
            'achieved' => false
        ],
        [
            'year' => 2019,
            'month' => 8,
            'achieved' => true
        ],
        [
            'year' => 2019,
            'month' => 9,
            'achieved' => true
        ]
    ]
];

