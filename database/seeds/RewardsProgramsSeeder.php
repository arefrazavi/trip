<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardsProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rewards_programs')->truncate();
        DB::table('rewards_programs')->insert([
            [
                'id' => 1,
                'name' => 'Monthly Service Excellence'
            ],
            [
                'id' => 2,
                'name' => 'Annual Booking Goal'
            ]
        ]);
    }
}
