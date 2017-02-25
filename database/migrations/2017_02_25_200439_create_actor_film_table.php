<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_film', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('actor_id');
            $table->unsignedInteger('film_id');
            $table->timestamps();

            $table->foreign('actor_id')
                  ->references('id')->on('actors')
                  ->onDelete('cascade');

            $table->foreign('film_id')
                  ->references('id')->on('films')
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
        Schema::dropIfExists('actor_film');
    }
}
