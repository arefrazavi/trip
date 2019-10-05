<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceExcellence extends Model
{
    /**
     * Get the agency that have the service excellence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

}
