<?php

namespace Tests\Unit\Services;

use App\Models\Agency;
use App\Models\BookingGoal;
use App\Models\RewardsProgram;
use App\Services\BookingGoalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingGoalServiceTest extends TestCase
{
    use RefreshDatabase;

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
     * Test calculateReward method
     * @return void
     */
    public function testCalculateReward(): void
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
                if($fakeData['year'] == $year) {
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

            if($achievement >= $target) {
                $expectedRewards[] = [
                    'agency' => $agencyName,
                    'reward' => $achievement * $this->bookingGoalService::REWARD_FEE_PERCENTAGE
                ];
            }
        }

        /* Run the method and test the result */
        $agencyRewards = $this->bookingGoalService->calculateReward('2019');
        $this->assertEquals($expectedRewards, $agencyRewards, "Wrong Rewards Calculation");
    }
}
