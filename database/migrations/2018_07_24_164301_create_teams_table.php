<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('name', 80);
            $table->string('primary_colour', 30)->nullable();
            $table->string('secondary_colour', 30)->nullable();
            $table->string('tertiary_colour', 30)->nullable();
            $table->text('logo_url')->nullable();
            $table->text('narrative')->nullable();


            $table->unsignedInteger('club_id')->nullable();
            $table->unsignedInteger('division_id')->nullable();

            $table->boolean('deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
