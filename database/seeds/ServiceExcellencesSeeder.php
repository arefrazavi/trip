<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceExcellencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('service_excellences')->truncate();
        DB::table('service_excellences')->insert([
            [
                'id' => 1,
                'agency_id' => 1,
                'year' => 2019,
                'month' => 7,
                'achieved' => true
            ],
            [
                'id' => 2,
                'agency_id' => 2,
                'year' => 2019,
                'month' => 7,
                'achieved' => false
            ],
            [
                'id' => 3,
                'agency_id' => 3,
                'year' => 2019,
                'month' => 7,
                'achieved' => false
            ],
            [
                'id' => 4,
                'agency_id' => 1,
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'id' => 5,
                'agency_id' => 2,
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'id' => 6,
                'agency_id' => 3,
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'id' => 7,
                'agency_id' => 1,
                'year' => 2019,
                'month' => 9,
                'achieved' => false
            ],
            [
                'id' => 8,
                'agency_id' => 2,
                'year' => 2019,
                'month' => 9,
                'achieved' => true
            ],
            [
                'id' => 9,
                'agency_id' => 3,
                'year' => 2019,
                'month' => 9,
                'achieved' => true
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
