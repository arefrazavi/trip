<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agency_id');
            $table->year('year');
            $table->bigInteger('target');
            $table->bigInteger('achievement');
        });

        Schema::table('booking_goals', function (Blueprint $table) {
            $table->unique(['agency_id', 'year']);
            $table->foreign('agency_id')
                ->references('id')->on('agencies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_goals', function (Blueprint $table) {
            $table->dropForeign(['agency_id']);
            $table->dropUnique(['agency_id', 'year']);

        });

        Schema::dropIfExists('booking_goals');
    }
}
