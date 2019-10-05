<?php

namespace App\Services;

use App\Models\BookingGoal;
use App\Models\RewardsProgram;
use App\Services\Interfaces\RewardsProgramInterface;

class BookingGoalService implements RewardsProgramInterface
{
    /**
     * Database ID of Annual Booking Goal rewards program
     *
     * @var int
     */
    public const REWARDS_PROGRAM_ID = 2;

    /**
     * Percentage of the achievement rewarded to the agency
     *
     * @var int
     */
    public const REWARD_FEE_PERCENTAGE = 0.01;

    /**
     * @var BookingGoal
     */
    private $bookingGoalClass;

    /**
     * BookingGoalService constructor.
     * @param BookingGoal $bookingGoalClass
     */
    public function __construct(BookingGoal $bookingGoalClass)
    {
        $this->bookingGoalClass = $bookingGoalClass;
    }

    /**
     * Calculate the total reward amount of thee Annual Booking Goal rewards program
     * for each enrolled agency in a given year
     *
     * @param int $year
     * @param int|null $month
     * @return array
     */
    public function calculateReward(int $year, int $month = null): array
    {
        $whereClause = [
            ['agency_rewards_program.rewards_program_id', self::REWARDS_PROGRAM_ID]
        ];
        if ($year) {
            $whereClause[] = ['year', $year];
        }
        $selectClause = "agencies.name AS agency, SUM(achievement) * ? AS reward";

        $agencyRewards = $this->bookingGoalClass
            ::selectRaw($selectClause, [self::REWARD_FEE_PERCENTAGE])
            ->join('agencies', 'agencies.id', '=', 'booking_goals.agency_id')
            ->join('agency_rewards_program', 'agency_rewards_program.agency_id', 'agencies.id')
            ->where($whereClause)
            ->groupBy('booking_goals.agency_id')
            ->get();

        return $agencyRewards->toArray();

    }
}
