<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingGoal extends Model
{
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
