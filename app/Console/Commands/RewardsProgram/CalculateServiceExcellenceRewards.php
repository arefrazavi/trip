<?php

namespace App\Console\Commands\RewardsProgram;

use App\Services\ServiceExcellenceService;
use Illuminate\Console\Command;

class CalculateServiceExcellenceRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tet:calculate-service-excellence-rewards {year} {month?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate all monthly service excellence rewards 
    for each enrolled agency that has won a reward in a given year/month';

    /**
     * @var ServiceExcellenceService
     */
    private $serviceExcellenceService;

    /**
     * Create a new command instance.
     *
     * @param ServiceExcellenceService $serviceExcellenceService
     */
    public function __construct(ServiceExcellenceService $serviceExcellenceService)
    {
        parent::__construct();
        $this->serviceExcellenceService = $serviceExcellenceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $agencyRewards = $this->serviceExcellenceService->calculateReward(
            $this->argument('year'),
            $this->argument('month')
        );

        if (!$agencyRewards) {
            $this->warn("No result was found!");

            return 0;
        }

        $headers = ['Agency', 'Service Excellence Reward(€)'];
        $this->table($headers, $agencyRewards);

        return 1;
    }
}
