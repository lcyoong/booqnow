<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bookings', function (Blueprint $table) {
          $table->increments('book_id');
          $table->integer('book_resource');
          $table->integer('book_customer');
          $table->datetime('book_from');
          $table->datetime('book_to');
          $table->datetime('book_checkin')->nullable();
          $table->datetime('book_checkout')->nullable();
          $table->integer('book_pax')->default(0);
          $table->string('book_reference')->nullable();
          $table->string('book_tracking')->nullable();
          $table->string('book_status')->default('active');
          $table->integer('created_by');
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
      Schema::drop('bookings');
    }
}
