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

            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);

            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('season_id')->nullable();

            $table->unsignedInteger('home_id')->nullable();
            $table->unsignedInteger('away_id')->nullable();

            $table->dateTime('match_date');
            $table->unsignedInteger('court');
            $table->unsignedInteger('round');

            $table->boolean('played')->default(false);
            $table->boolean('walkover_home')->default(false);
            $table->boolean('walkover_away')->default(false);

            $table->integer('home_adjust')->default(0);
            $table->integer('away_adjust')->default(0);

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
