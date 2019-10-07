<?php

namespace Tests\Unit\Models;

use App\Models\ServiceExcellence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceExcellenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test setYearAttribute method
     *
     * @return void
     */
    public function testSetYearAttribute()
    {
        $serviceExcellence = factory(ServiceExcellence::class)->create();

        /* Valid month */
        $expectedYear = 2018;
        $serviceExcellence->year = $expectedYear;
        $serviceExcellence->save();
        $this->assertEquals($expectedYear, $serviceExcellence->year);

        /* Invalid value type of year */
        $this->expectExceptionMessage('must be of the type int');
        $expectedYear = 'two';
        $serviceExcellence->month = $expectedYear;
    }

    /**
     * Test setMonthAttribute method
     *
     * @return void
     */
    public function testSetMonthAttribute()
    {
        $agency = factory(ServiceExcellence::class)->create();

        /* Valid month */
        $expectedMonth = 3;
        $agency->month = $expectedMonth;
        $agency->save();
        $this->assertEquals($expectedMonth, $agency->month);

        /* Invalid value type of month */
        $this->expectExceptionMessage('must be of the type int');
        $expectedMonth = 'three';
        $agency->month = $expectedMonth;

        /* Value of month out of the integer range */
        $this->expectExceptionMessage('Month can be an integer between 1 and 12');
        $expectedMonth = 13;
        $agency->month = $expectedMonth;
    }

}
