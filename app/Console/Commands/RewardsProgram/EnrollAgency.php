<?php

namespace App\Console\Commands\RewardsProgram;

use App\Models\Agency;
use App\Services\AgencyService;
use Illuminate\Console\Command;

class EnrollAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tet:enroll-agency {agencyId} {rewardsProgramId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enroll a given agency into a given rewards program';

    private $agencyServiceClass;

    /**
     * Create a new command instance.
     *
     * @param AgencyService $agencyServiceClass
     */
    public function __construct(AgencyService $agencyServiceClass)
    {
        parent::__construct();
        $this->agencyServiceClass = $agencyServiceClass;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $enrollmentResult = $this->agencyServiceClass->enrollAgency($this->argument('agencyId'), $this->argument('rewardsProgramId'));
        if (isset($enrollmentResult['success'])) {
            $this->info("OK");
        } else {
            $this->warn($enrollmentResult['error']);
        }
    }
}
