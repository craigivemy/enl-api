<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayedUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('played_ups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->date('played_up_date');
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('season_id');

            $table->timestamps();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
                ->onDelete('cascade')
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
        Schema::dropIfExists('played_ups');
    }
}
