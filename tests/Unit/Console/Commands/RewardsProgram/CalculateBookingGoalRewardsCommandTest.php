<?php

namespace Tests\Unit\Console\Commands\RewardsProgram;

use App\Console\Commands\RewardsProgram\CalculateBookingGoalRewards;
use App\Console\Commands\RewardsProgram\CalculateServiceExcellenceRewards;
use App\Models\Agency;
use App\Models\BookingGoal;
use App\Models\RewardsProgram;
use App\Services\BookingGoalService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

class CalculateBookingGoalRewardsCommandTest extends TestCase
{
    use RefreshDatabase;

    public const COMMAND_BASE_SIGNATURE = "tet:calculate-booking-goal-rewards";

    /**
     * @var array
     */
    protected $fakeBookingGoalsData = [
        'Agency 1' => [
            [
                'year' => 2019,
                'target' => 1000000,
                'achievement' => 890000
            ]
        ],
        'Agency 2' => [
            [
                'year' => 2019,
                'target' => 200000,
                'achievement' => 230000
            ]
        ],
        'Agency 3' => [
            [
                'year' => 2019,
                'target' => 125000,
                'achievement' => 140000
            ]
        ]
    ];

    /**
     * @var RewardsProgram
     */
    protected $rewardsProgram;

    /**
     * @var BookingGoalService
     */
    private $bookingGoalService;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookingGoalService = new BookingGoalService(new BookingGoal());
        $this->rewardsProgram = factory(RewardsProgram::class)->create([
            'id' => RewardsProgram::ANNUAL_BOOKING_GOAL_ID,
        ]);
    }

    /**
     *
     * Test the command when there is at least one agency winning a reward
     * @return void
     */
    public function testExistsAgencyWithReward(): void
    {
        /* Populate Fake Data */
        $year = '2019';
        $expectedRewards = [];
        foreach ($this->fakeBookingGoalsData as $agencyName => $fakeDataArray) {
            $agency = factory(Agency::class)->create([
                'name' => $agencyName
            ]);

            $achievement = 0;
            $target = 1;
            foreach ($fakeDataArray as $fakeData) {
                $agency->bookingGoals()
                    ->save(factory(BookingGoal::class)
                        ->create($fakeData)
                    );
                if ($fakeData['year'] == $year) {
                    $achievement = $fakeData['achievement'];
                    $target = $fakeData['target'];
                }
            }

            // Agency 3 with achievement more than target does not enroll
            if ($agency->id == 3) {
                continue;
            }

            $agency->rewardsPrograms()->syncWithoutDetaching(
                [$this->rewardsProgram->id => ['created_at' => new \DateTime()]]
            );

            if ($achievement >= $target) {
                $expectedRewards[] = [
                    'agency' => $agencyName,
                    'reward' => $achievement * $this->bookingGoalService::REWARD_FEE_PERCENTAGE
                ];
            }
        }

        /* Run the command and test the result by return code */
        $this->artisan(self::COMMAND_BASE_SIGNATURE . " $year")
             ->assertExitCode(1);
    }

    /**
     * Test the command when one mandatory argument is missing
     */
    public function testMissingArgument() : void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "year").');

        $this->artisan(self::COMMAND_BASE_SIGNATURE);
    }

    /**
     * Test the command when there is no agency with reward
     */
    public function testNotExistsAgencyWithReward() : void
    {
        $year = '2020';

        $this->artisan(self::COMMAND_BASE_SIGNATURE . " $year")
        ->expectsOutput("There is no agency winning booking goal reward yet!");
    }
}
