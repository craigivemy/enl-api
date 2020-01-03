<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamPointAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_point_adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('point_adjustment')->default(0);
            $table->string('reason');
            $table->date('reason_date');

            $table->unsignedInteger('team_id')->nullable();
            $table->unsignedInteger('season_id')->nullable();

            $table->timestamps();

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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_point_adjustments');
    }
}
