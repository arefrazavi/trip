<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardsProgram extends Model
{
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
