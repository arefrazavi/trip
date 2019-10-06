<?php

namespace Tests\Unit\Services;

use App\Models\Agency;
use App\Models\RewardsProgram;
use App\Services\AgencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyServiceTest extends TestCase
{
    use RefreshDatabase;

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
     * Test enrollAgency method
     */
    public function testEnrollAgency(): void
    {
        /* Valid Enrollment */
        $agencyId = factory(Agency::class)->create()->id;
        $rewardProgramId = factory(RewardsProgram::class)->create()->id;
        $result = $this->agencyService->enrollAgency($agencyId, $rewardProgramId);

        $this->assertArrayHasKey('success', $result, "Valid Enrollment should return success.");

        /* Invalid Enrollment: Invalid agency ID */
        $agencyId = -1;
        $rewardProgramId = factory(RewardsProgram::class)->create()->id;
        $result = $this->agencyService->enrollAgency($agencyId, $rewardProgramId);
        $expectedResult = ["error" => "Agency with ID $agencyId was not found."];
        $this->assertEquals($expectedResult, $result, "Enrollment of invalid agency should fail with proper message.");

        /* Invalid Enrollment: Invalid rewards program ID */
        $agencyId = factory(Agency::class)->create()->id;
        $rewardProgramId = -1;
        $result = $this->agencyService->enrollAgency($agencyId, $rewardProgramId);
        $expectedResult = ["error" => "Rewards Program with ID $rewardProgramId was not found."];
        $this->assertEquals($expectedResult, $result, "Enrollment of invalid agency should fail with proper message.");
    }

    /**
     * Test getAllEnrolledAgencies method
     */
    public function testGetAllEnrolledAgencies(): void
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


        /* Call the method and test the result */
        $enrolledAgencies = $this->agencyService->getAllEnrolledAgencies();
        $enrolledAgenciesCount = [
            RewardsProgram::MONTHLY_SERVICE_EXCELLENCE_ID => 0,
            RewardsProgram::ANNUAL_BOOKING_GOAL_ID => 0,
        ];
        foreach ($enrolledAgencies as $enrolledAgency) {
            foreach ($enrolledAgency->rewardsPrograms as $rewardsProgram) {
                $enrolledAgenciesCount[$rewardsProgram->id]++;
            }
        }
        // Compare the number of enrolled agencies in each rewards program
        $this->assertEquals(array_sum($expectedEnrolledAgenciesCount), $enrolledAgencies->count(), "getAllEnrolledAgencies should return all of the enrolled agencies");

    }
}
