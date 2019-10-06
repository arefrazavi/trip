<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {dbName?} {test=testing_db}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a MySQL database and its optional testing db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbName = $this->argument('dbName') ?: config("database.connections.mysql.database");
        $charset = config("database.connections.mysql.charset",'utf8mb4');
        $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

        config(["database.connections.mysql.database" => null]);

        $query = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);

        $this->info("Database $dbName has been created!\n");

        if ($this->argument('test')) {
            $dbName = $this->argument('test') ?: config("database.connections.testing.database");
            $charset = config("database.connections.testing.charset",'utf8mb4');
            $collation = config("database.connections.testing.collation",'utf8mb4_unicode_ci');
            config(["database.connections.testing.database" => null]);
            $query = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE $collation;";
            DB::statement($query);

            $this->info("Test Database $dbName has been created!\n");
        }
    }
}
