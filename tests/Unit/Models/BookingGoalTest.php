<?php

namespace Tests\Unit\Models;

use App\Models\BookingGoal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingGoalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test setYearAttribute method
     *
     * @return void
     */
    public function testSetYearAttribute()
    {
        $bookingGoal = factory(BookingGoal::class)->create();

        /* Valid month */
        $expectedYear = 2018;
        $bookingGoal->year = $expectedYear;
        $bookingGoal->save();
        $this->assertEquals($expectedYear, $bookingGoal->year);

        /* Invalid value type of year */
        $this->expectExceptionMessage('must be of the type int');
        $expectedYear = 'two';
        $bookingGoal->year = $expectedYear;
    }

    /**
     * Test setTargetAttribute method
     *
     * @return void
     */
    public function testSetTargetAttribute()
    {
        $bookingGoal = factory(BookingGoal::class)->create();

        /* Valid month */
        $expectedTarget = 333332;
        $bookingGoal->target = $expectedTarget;
        $bookingGoal->save();
        $this->assertEquals(
            $expectedTarget,
            $bookingGoal->target
        );

        /* Invalid value type of target */
        $this->expectExceptionMessage('must be of the type int');
        $expectedTarget = 'two';
        $bookingGoal->target = $expectedTarget;
    }

    /**
     * Test setAchievementAttribute method
     *
     * @return void
     */
    public function testSetAchievementAttribute()
    {
        $bookingGoal = factory(BookingGoal::class)->create();

        /* Valid month */
        $expectedAchievement = 332343;
        $bookingGoal->achievement = $expectedAchievement;
        $this->assertEquals(
            $expectedAchievement,
            $bookingGoal->achievement,
            "Achievement field should be changed");

        /* Invalid value type of achievement */
        $this->expectExceptionMessage('must be of the type int');
        $expectedAchievement = 'two';
        $bookingGoal->achievement = $expectedAchievement;
    }
}
