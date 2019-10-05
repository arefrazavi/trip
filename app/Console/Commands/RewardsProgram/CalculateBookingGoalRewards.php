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
    protected $description = 'Calculate all annual booking goal rewards per agency in a given year';

    /**
     * @var BookingGoalService
     */
    private $bookingGoalServiceClass;

    /**
     * Create a new command instance.
     *
     * @param BookingGoalService $bookingGoalServiceClass
     */
    public function __construct(BookingGoalService $bookingGoalServiceClass)
    {
        parent::__construct();
        $this->bookingGoalServiceClass = $bookingGoalServiceClass;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $agencyRewards = $this->bookingGoalServiceClass->calculateReward($this->argument('year'));

        if ($agencyRewards) {
            $headers = ['Agency', 'Booking Goal Reward'];
            $this->table($headers, $agencyRewards);
        } else {
            $this->warn("No result was found!");
        }
    }
}
