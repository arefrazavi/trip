<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AgenciesSeeder::class);
        $this->call(RewardsProgramsSeeder::class);
        $this->call(BookingGoalsSeeder::class);
        $this->call(ServiceExcellencesSeeder::class);
    }
}
