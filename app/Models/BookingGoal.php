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
}
