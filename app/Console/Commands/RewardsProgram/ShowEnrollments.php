<?php

namespace App\Console\Commands\RewardsProgram;

use App\Models\Agency;
use App\Services\AgencyService;
use Illuminate\Console\Command;

class ShowEnrollments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tet:show-enrollments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'See all agency enrollments into rewards programs';

    /**
     * @var AgencyService
     */
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
        $agencies = $this->agencyService->getAllEnrolledAgencies();

        if ($agencies->isEmpty()) {
            $this->warn("No agency has enrolled in any rewards program yet!");
            return 0;
        }

        $result = [];
        foreach ($agencies as $agency) {
            $result[$agency->id]['name'] = $agency->name;
            $rewardsNum = count($agency->rewardsPrograms);
            $result[$agency->id]['rewardPrograms'] = '';
            for ($i = 0; $i < $rewardsNum; $i++) {
                $result[$agency->id]['rewardPrograms'] .= $agency->rewardsPrograms[$i]['name'];
                $result[$agency->id]['rewardPrograms'] .= ($i < $rewardsNum - 1) ? ", " : "";
            }
        }

        $headers = ['Agency', 'Rewards Programs'];
        $this->table($headers, $result);

        return 1;
    }
}
