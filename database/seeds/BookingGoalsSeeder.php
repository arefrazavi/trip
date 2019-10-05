<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingGoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('booking_goals')->truncate();
        DB::table('booking_goals')->insert([
            [
                'id' => 1,
                'agency_id' => 1,
                'year' => 2019,
                'target' => 1000000,
                'achievement' => 870000
            ],
            [
                'id' => 2,
                'agency_id' => 2,
                'year' => 2019,
                'target' => 200000,
                'achievement' => 230000
            ],[
                'id' => 3,
                'agency_id' => 3,
                'year' => 2019,
                'target' => 125000,
                'achievement' => 110000
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
