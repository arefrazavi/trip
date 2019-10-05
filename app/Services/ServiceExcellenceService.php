<?php

namespace App\Services;

use App\Models\RewardsProgram;
use App\Models\ServiceExcellence;
use App\Services\Interfaces\RewardsProgramInterface;

class ServiceExcellenceService implements RewardsProgramInterface
{
    /**
     * Database ID of Monthly Service Excellence rewards program
     *
     * @var int
     */
    public const REWARDS_PROGRAM_ID = 1;

    /**
     *  a fixed amount of reward for each achieved service in Euro
     *
     * @var float
     */
    public const REWARD_FEE = 500;

    /**
     * @var ServiceExcellence
     */
    private $serviceExcellenceClass;

    /**
     * ServiceExcellenceService constructor.
     * @param ServiceExcellence $serviceExcellenceClass
     */
    public function __construct(ServiceExcellence $serviceExcellenceClass)
    {
        $this->serviceExcellenceClass = $serviceExcellenceClass;
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
            ['agency_rewards_program.rewards_program_id', self::REWARDS_PROGRAM_ID]
        ];
        if ($year) {
            $whereClause[] = ['year', $year];
        }
        if ($month) {
            $whereClause[] = ['month', $month];
        }
        $selectClause = "agencies.name AS agency, COUNT(*) * ? AS reward";

        $agencyRewards = $this->serviceExcellenceClass
            ::selectRaw($selectClause, [self::REWARD_FEE])
            ->join('agencies', 'agencies.id', '=', 'service_excellences.agency_id')
            ->join('agency_rewards_program', 'agency_rewards_program.agency_id', 'agencies.id')
            ->where($whereClause)
            ->groupBy('service_excellences.agency_id')
            ->get();

        return $agencyRewards->toArray();
    }
}
