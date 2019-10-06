<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardsProgram extends Model
{
    /**
     * Database ID of Monthly Service Excellence rewards program
     *
     * @var int
     */
    public const MONTHLY_SERVICE_EXCELLENCE_ID = 1;


    /**
     * Annual Booking Goal rewards program ID
     *
     * @var int
     */
    public const ANNUAL_BOOKING_GOAL_ID = 2;


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the agencies that offer the rewards program
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agencies()
    {
        return $this->belongsToMany(Agency::class);

    }
}
