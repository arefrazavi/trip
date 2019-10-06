<?php

namespace App\Services;

use App\Models\RewardsProgram;
use App\Models\ServiceExcellence;
use App\Services\Interfaces\RewardsProgramInterface;

class ServiceExcellenceService implements RewardsProgramInterface
{
    /**
     *  a fixed amount of reward for each achieved service in Euro
     *
     * @var float
     */
    public const REWARD_FEE = 500;

    /**
     * @var ServiceExcellence
     */
    private $serviceExcellence;

    /**
     * ServiceExcellenceService constructor.
     * @param ServiceExcellence $serviceExcellence
     */
    public function __construct(ServiceExcellence $serviceExcellence)
    {
        $this->serviceExcellence = $serviceExcellence;
    }

    /**
     * Calculate the total reward amount of the Monthly Service Excellence rewards program
     * for each enrolled agency in a given year/month
     *
     * @param int $year
     * @param int|null $month
     * @return array
     */
    public function calculateReward(int $year, int $month = null): array
    {
        $whereClause = [
            ['achieved', true],
            ['agency_rewards_program.rewards_program_id', RewardsProgram::MONTHLY_SERVICE_EXCELLENCE_ID]
        ];
        if ($year) {
            $whereClause[] = ['year', $year];
        }
        if ($month) {
            $whereClause[] = ['month', $month];
        }
        $selectClause = "agencies.name AS agency, COUNT(*) * ? AS reward";

        $agencyRewards = $this->serviceExcellence
            ::selectRaw($selectClause, [self::REWARD_FEE])
            ->join('agencies', 'agencies.id', '=', 'service_excellences.agency_id')
            ->join('agency_rewards_program', 'agency_rewards_program.agency_id', 'agencies.id')
            ->where($whereClause)
            ->groupBy('service_excellences.agency_id')
            ->get();

        return $agencyRewards->toArray();
    }
}
