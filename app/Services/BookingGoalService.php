<?php

namespace App\Services;

use App\Models\BookingGoal;
use App\Models\RewardsProgram;
use App\Services\Interfaces\RewardsProgramInterface;

class BookingGoalService implements RewardsProgramInterface
{

    /**
     * Percentage of the achievement rewarded to the agency
     *
     * @var int
     */
    public const REWARD_FEE_PERCENTAGE = 0.01;

    /**
     * @var BookingGoal
     */
    private $bookingGoal;

    /**
     * BookingGoalService constructor.
     * @param BookingGoal $bookingGoal
     */
    public function __construct(BookingGoal $bookingGoal)
    {
        $this->bookingGoal = $bookingGoal;
    }

    /**
     * Calculate the total reward amount of thee Annual Booking Goal rewards program
     * for each enrolled agency which has achieved its goal in a given year
     *
     * @param int $year
     * @param int|null $month
     * @return array
     */
    public function calculateReward(int $year, int $month = null): array
    {
        $whereClause = [
            ['agency_rewards_program.rewards_program_id', RewardsProgram::ANNUAL_BOOKING_GOAL_ID],
        ];
        if ($year) {
            $whereClause[] = ['year', $year];
        }
        $selectClause = "agencies.name AS agency, achievement * ? AS reward";

        $agencyRewards = $this->bookingGoal
            ::selectRaw($selectClause, [self::REWARD_FEE_PERCENTAGE])
            ->join('agencies', 'agencies.id', '=', 'booking_goals.agency_id')
            ->join('agency_rewards_program', 'agency_rewards_program.agency_id', 'agencies.id')
            ->where($whereClause)
            ->whereRaw('achievement >= target')
            ->get();

        return $agencyRewards->toArray();
    }
}
