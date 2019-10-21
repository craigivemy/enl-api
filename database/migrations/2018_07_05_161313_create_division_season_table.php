<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create('division_season', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('season_id')->nullable();
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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('division_season');
    }
}
