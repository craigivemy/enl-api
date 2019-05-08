<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id')->nullable();
            $table->unsignedInteger('season_id')->nullable();
            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('player_id')->nullable();
            $table->unsignedInteger('played');
            $table->unsignedInteger('wins');
            $table->unsignedInteger('losses');
            $table->unsignedInteger('draws');
            $table->unsignedInteger('scored');
            $table->unsignedInteger('conceeded');
            $table->unsignedInteger('goal_difference');
            $table->unsignedInteger('bonus_points');
            $table->integer('points');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
