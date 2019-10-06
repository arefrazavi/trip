<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the rewards programs that agency offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewardsPrograms()
    {
        return $this->belongsToMany(RewardsProgram::class);
    }

    /**
     * Get the booking goals of the agency
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookingGoals()
    {
        return $this->hasMany(BookingGoal::class);
    }

    /**
     * Get the service excellences of the agency
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceExcellences()
    {
        return $this->hasMany(ServiceExcellence::class);
    }

}
