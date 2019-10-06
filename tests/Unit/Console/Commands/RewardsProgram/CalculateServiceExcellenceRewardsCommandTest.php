<?php

namespace Tests\Unit\Services\Console\Commands\RewardsProgram;

use App\Models\Agency;
use App\Models\RewardsProgram;
use App\Models\ServiceExcellence;
use App\Services\ServiceExcellenceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateServiceExcellenceRewardsCommandTest extends TestCase
{
    use RefreshDatabase;

    public const COMMAND_BASE_SIGNATURE = "tet:calculate-service-excellence-rewards";

    /**
     * @var array
     */
    protected $fakeServiceExcellencesData = [
        'Agency 1' => [
            [
                'year' => 2019,
                'month' => 7,
                'achieved' => true
            ],
            [
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'year' => 2019,
                'month' => 9,
                'achieved' => false
            ]
        ],
        'Agency 2' => [
            [
                'year' => 2019,
                'month' => 7,
                'achieved' => false
            ],
            [
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'year' => 2019,
                'month' => 9,
                'achieved' => true
            ]
        ],
        'Agency 3' => [
            [
                'year' => 2019,
                'month' => 7,
                'achieved' => false
            ],
            [
                'year' => 2019,
                'month' => 8,
                'achieved' => true
            ],
            [
                'year' => 2019,
                'month' => 9,
                'achieved' => true
            ]
        ]
    ];

    /**
     * @var RewardsProgram
     */
    protected $rewardsProgram;

    /**
     * @var ServiceExcellenceService
     */
    private $serviceExcellencesService;

    public function setUp(): void
    {
        parent::setUp();

        $this->serviceExcellencesService = new ServiceExcellenceService(new ServiceExcellence());

        $this->rewardsProgram = factory(RewardsProgram::class)->create([
            'id' => RewardsProgram::MONTHLY_SERVICE_EXCELLENCE_ID,
        ]);
    }

    /**
     * Test the command when there is at least one agency winning a reward
     *
     * @return void
     */
    public function testExistsAgencyWithReward(): void
    {
        /* Populate Fake Data */
        $year = 2019;
        $expectedRewards = [];
        foreach ($this->fakeServiceExcellencesData as $agencyName => $fakeDataArray) {
            $agency = factory(Agency::class)
                ->create([
                    'name' => $agencyName
                ]);

            $achievedServicesCount = 0;
            foreach ($fakeDataArray as $fakeData) {
                $agency->ServiceExcellences()
                    ->save(factory(ServiceExcellence::class)
                        ->create($fakeData)
                    );
                if($fakeData['achieved'] && $fakeData['year'] == $year) {
                    $achievedServicesCount++;
                }
            }

            // Agency 2 does not enroll
            if ($agency->id == 2) {
                continue;
            }

            $agency->rewardsPrograms()->syncWithoutDetaching(
                [$this->rewardsProgram->id => ['created_at' => new \DateTime()]]
            );
            $expectedRewards[] = [
                'agency' => $agencyName,
                'reward' => $achievedServicesCount * ServiceExcellenceService::REWARD_FEE
            ];

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
            ->expectsOutput("No result was found!");
    }
}
