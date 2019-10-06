<?php

namespace Tests\Unit\Console\Commands\RewardsProgram;

use App\Models\Agency;
use App\Models\RewardsProgram;
use App\Services\AgencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollAgencyCommandTest extends TestCase
{
    use RefreshDatabase;

    public const COMMAND_BASE_SIGNATURE = "tet:enroll-agency";

    /**
     * @var AgencyService
     */
    private $agencyService;

    public function setUp() : void
    {
        parent::setUp();

        $this->agencyService = new AgencyService(new Agency());
    }

    /**
     * Test the commend when agency and rewards program are valid
     *
     * @return void
     */
    public function testValidEnrollment() : void
    {
        $agencyId = factory(Agency::class)->create()->id;
        $rewardProgramId = factory(RewardsProgram::class)->create()->id;
        $this->artisan("tet:enroll-agency $agencyId $rewardProgramId")
            ->expectsOutput("OK");
    }


    /**
     * Test the command when agent is not found
     *
     * @return void
     */
    public function testInvalidAgency() : void
    {
        $agencyId = -1;
        $rewardProgramId = factory(RewardsProgram::class)->create()->id;
        $this->artisan(self::COMMAND_BASE_SIGNATURE . " -- $agencyId $rewardProgramId")
            ->expectsOutput("Agency with ID $agencyId was not found.");
    }

    /**
     * Test the command when rewards program is not found
     *
     * @return void
     */
    public function testInvalidRewardsProgram() : void
    {
        $agencyId = factory(Agency::class)->create()->id;
        $rewardProgramId = -1;
        $this->artisan(self::COMMAND_BASE_SIGNATURE . " -- $agencyId $rewardProgramId")
            ->expectsOutput("Rewards Program with ID $rewardProgramId was not found.");
    }
}
