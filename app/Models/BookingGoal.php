<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingGoal extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the agency that have the Booking goal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Set value of year attribute after type validation
     *
     * @param int $value
     */
    public function setYearAttribute(int $value): void
    {
        $this->attributes['year'] = $value;
    }

    /**
     * Set value of target attribute after type validation
     *
     * @param int $value
     */
    public function setTargetAttribute(int $value): void
    {
        $this->attributes['target'] = $value;
    }


    /**
     * Set value of achievement attribute after type validation
     *
     * @param int $value
     */
    public function setAchievementAttribute(int $value): void
    {
        $this->attributes['achievement'] = $value;
    }
}
