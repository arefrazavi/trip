<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceExcellence extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the agency that have the service excellence
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
     * Set value of month attribute after validations
     *
     * @param int $value
     * @throws \Exception
     */
    public function setMonthAttribute(int $value): void
    {
        if ($value < 1 || $value > 12) {
            throw new \Exception('Month can be an integer between 1 and 12');
        }

        $this->attributes['month'] = $value;
    }

}
