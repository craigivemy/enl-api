<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('home_score');
            $table->integer('away_score');

            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('season_id')->nullable();

            $table->unsignedInteger('home_id')->nullable();
            $table->unsignedInteger('away_id')->nullable();

            $table->timestamp('match_date');
            $table->unsignedInteger('round');

            $table->boolean('played');
            $table->boolean('walkover');

            $table->integer('home_adjust');
            $table->integer('away_adjust');

            $table->timestamps();
            $table->softDeletes();


            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('home_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('away_id')
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
        Schema::dropIfExists('matches');
    }
}
