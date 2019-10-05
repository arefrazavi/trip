<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('agencies')->truncate();
        DB::table('agencies')->insert([
            [
                'id' => 1,
                'name' => 'Best India Tours'
            ],
            [
                'id' => 2,
                'name' => 'Discover Peru'
            ],
            [
                'id' => 3,
                'name' => 'Luxury France'
            ]
        ]);
    }
}
