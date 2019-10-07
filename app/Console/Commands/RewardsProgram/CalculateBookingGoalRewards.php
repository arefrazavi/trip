<?php

namespace App\Console\Commands\RewardsProgram;

use App\Services\BookingGoalService;
use Illuminate\Console\Command;

class CalculateBookingGoalRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tet:calculate-booking-goal-rewards {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate all annual booking goal rewards 
    for each enrolled agency that has won a reward in a given year';

    /**
     * @var BookingGoalService
     */
    private $bookingGoalService;

    /**
     * Create a new command instance.
     *
     * @param BookingGoalService $bookingGoalService
     */
    public function __construct(BookingGoalService $bookingGoalService)
    {
        parent::__construct();
        $this->bookingGoalService = $bookingGoalService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $agencyRewards = $this->bookingGoalService->calculateReward($this->argument('year'));

        if (!$agencyRewards) {
            $this->warn("No result was found!");

            return 0;
        }
        $headers = ['Agency', 'Booking Goal Reward (€)'];
        $this->table($headers, $agencyRewards);

        return 1;
    }
}
