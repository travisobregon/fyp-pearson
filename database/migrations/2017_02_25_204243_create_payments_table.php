<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rental_id')->nullable();
            $table->unsignedInteger('staff_id');
            $table->unsignedInteger('user_id');
            $table->decimal('amount', 5, 2);
            $table->dateTime('paid_on');
            $table->timestamps();

            $table->foreign('rental_id')
                  ->references('id')->on('rentals')
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
        Schema::dropIfExists('payments');
    }
}
