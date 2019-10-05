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
    protected $description = 'Calculate all monthly service excellence rewards per agency in a given year/month';

    /**
     * @var ServiceExcellenceService
     */
    private $serviceExcellenceServiceClass;

    /**
     * Create a new command instance.
     *
     * @param ServiceExcellenceService $serviceExcellenceServiceClass
     */
    public function __construct(ServiceExcellenceService $serviceExcellenceServiceClass)
    {
        parent::__construct();
        $this->serviceExcellenceServiceClass = $serviceExcellenceServiceClass;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $agencyRewards = $this->serviceExcellenceServiceClass->calculateReward(
            $this->argument('year'),
            $this->argument('month')
        );

        if ($agencyRewards) {
            $headers = ['Agency', 'Service Excellence Reward'];
            $this->table($headers, $agencyRewards);
        } else {
            $this->warn("No result was found!");
        }
    }
}
