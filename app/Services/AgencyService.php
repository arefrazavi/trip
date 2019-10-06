<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\RewardsProgram;

class AgencyService
{
    /**
     * @var Agency
     */
    private $agency;

    /**
     * AgencyService constructor.
     * @param Agency $agency
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    /**
     * Enroll a given agency ($agencyId) into a given rewards program ($rewardsProgramId)
     *
     * @param int $agencyId
     * @param int $rewardsProgramId
     * @return array
     */
    public function enrollAgency(int $agencyId, int $rewardsProgramId): array
    {
        if (!($agency = $this->agency::find($agencyId))) {
            return [
                'error' => "Agency with ID $agencyId was not found."
            ];
        }
        if (!($rewardsProgram = RewardsProgram::find($rewardsProgramId))) {
            return [
                'error' => "Rewards Program with ID $rewardsProgramId was not found."
            ];
        }
        try {
            $agency->rewardsPrograms()->syncWithoutDetaching(
                    [$rewardsProgramId => ['created_at' => new \DateTime()]]
                );
        } catch(\Exception $error) {
            return [
                'error' => $error->getMessage()
            ];
        }

        return ['success' => 1];
    }

    /**
     * Get all agencies, having enrolled in least one rewards program,
     * eith all of their enrolled programs
     *
     * @return object
     */
    public function getAllEnrolledAgencies() : object
    {
        return Agency::has('rewardsPrograms')
            ->with('rewardsPrograms')
            ->get();

    }
}
