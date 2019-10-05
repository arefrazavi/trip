<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgencyRewardsProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_rewards_program', function (Blueprint $table) {
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('rewards_program_id');
            $table->dateTime('created_at');
        });


        Schema::table('agency_rewards_program', function (Blueprint $table) {

            $table->primary(['agency_id', 'rewards_program_id']);

            $table->foreign('agency_id')
                ->references('id')->on('agencies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('rewards_program_id')
                ->references('id')->on('rewards_programs')
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
        Schema::table('agency_rewards_program', function (Blueprint $table) {
            $table->dropForeign(['agency_id']);
            $table->dropForeign(['rewards_program_id']);
            $table->dropPrimary(['agency_id', 'rewards_program_id']);
        });

        Schema::dropIfExists('agency_rewards_program');
    }
}
