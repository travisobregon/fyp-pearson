<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inventory_id');
            $table->unsignedInteger('staff_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('rented_on');
            $table->dateTime('returned_on')->nullable();
            $table->timestamps();

            $table->foreign('inventory_id')
                  ->references('id')->on('inventories')
                  ->onDelete('cascade');

            $table->foreign('staff_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('rentals');
    }
}
