<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceExcellencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_excellences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agency_id');
            $table->year('year');
            $table->tinyInteger('month');
            $table->boolean('achieved');
        });

        Schema::table('service_excellences', function (Blueprint $table) {
            $table->unique(['agency_id', 'year', 'month']);
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
        Schema::table('service_excellences', function (Blueprint $table) {
            $table->dropForeign(['agency_id']);
            $table->dropUnique(['agency_id', 'year', 'month']);
        });

        Schema::dropIfExists('service_excellences');
    }
}
