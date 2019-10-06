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

    private $agencyService;

    /**
     * Create a new command instance.
     *
     * @param AgencyService $agencyService
     */
    public function __construct(AgencyService $agencyService)
    {
        parent::__construct();
        $this->agencyService = $agencyService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $enrollmentResult = $this->agencyService->enrollAgency($this->argument('agencyId'), $this->argument('rewardsProgramId'));

        if (isset($enrollmentResult['error'])) {
            $this->warn($enrollmentResult['error']);

            return 0;
        }

        $this->info("OK");

        return 1;

    }
}
