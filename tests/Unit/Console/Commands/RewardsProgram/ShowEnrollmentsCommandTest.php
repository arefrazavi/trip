<?php

namespace Tests\Unit\Console\Commands\RewardsProgram;

use App\Models\Agency;
use App\Models\RewardsProgram;
use App\Services\AgencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowEnrollmentsCommandTest extends TestCase
{
    use RefreshDatabase;

    public const COMMAND_BASE_SIGNATURE = "tet:show-enrollments";

    /**
     * @var AgencyService
     */
    private $agencyService;

    public function setUp(): void
    {
        parent::setUp();

        $this->agencyService = new AgencyService(new Agency());
    }

    /**
     * Test the command method when there is at least one enrollment
     *
     * var void
     */
    public function testExistsEnrollment(): void
    {
        /* Populate fake data */
        $expectedEnrolledAgenciesCount = [
            RewardsProgram::MONTHLY_SERVICE_EXCELLENCE_ID => 4,
            RewardsProgram::ANNUAL_BOOKING_GOAL_ID => 5,
        ];
        foreach ($expectedEnrolledAgenciesCount as $rewardsProgramId => $agenciesCount) {
            factory(RewardsProgram::class)->create([
                'id' => $rewardsProgramId,
            ]);

            factory(Agency::class, $agenciesCount)
                ->create()
                ->each(function ($agency) use ($rewardsProgramId) {
                    $agency->rewardsPrograms()->syncWithoutDetaching(
                        [$rewardsProgramId => ['created_at' => new \DateTime()]]
                    );
                });
        }

        /* Run the command and test the result by return code */
        $this->artisan(self::COMMAND_BASE_SIGNATURE)
            ->assertExitCode(1);
    }

    /**
     * Test the command when there is no enrollment yet
     *
     * return void
     */
    public function testNotExistsAgencyWithReward() : void
    {
        $this->artisan(self::COMMAND_BASE_SIGNATURE)
            ->expectsOutput("No agency has enrolled in any rewards program yet!");
    }
}
