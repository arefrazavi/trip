<?php


namespace App\Services\Interfaces;


interface RewardsProgramInterface
{
    /**
     * Calculate the total reward amount of a reward program
     * for each enrolled agency in a given year/month
     *
     * @param int $year
     * @param int|null $month
     * @return array
     */
    public function calculateReward(int $year, int $month = null) : array;
}
