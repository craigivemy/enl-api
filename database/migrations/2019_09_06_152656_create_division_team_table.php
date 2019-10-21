<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create('division_team', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('team_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
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
        Schema::dropIfExists('division_team');
    }
}
