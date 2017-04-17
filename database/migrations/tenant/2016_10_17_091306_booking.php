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
      Schema::create('booking_sources', function (Blueprint $table) {
          $table->increments('bs_id');
          $table->string('bs_description');
          $table->string('bs_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('bookings', function (Blueprint $table) {
          $table->increments('book_id');
          $table->integer('book_resource');
          $table->integer('book_customer');
          $table->datetime('book_from');
          $table->datetime('book_to');
          $table->integer('book_source');
          $table->integer('book_agent')->nullable();
          $table->datetime('book_checkin')->nullable();
          $table->datetime('book_checkout')->nullable();
          $table->integer('book_pax')->default(0);
          $table->string('book_reference')->nullable();
          $table->string('book_tracking')->nullable();
          $table->string('book_status')->default('hold');
          $table->text('book_remarks')->nullable();
          $table->boolean('book_special')->default(0);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('addons', function (Blueprint $table) {
          $table->increments('add_id');
          $table->integer('add_booking')->nullable();
          $table->integer('add_resource');
          // $table->integer('add_bill');
          $table->integer('add_bill_item');
          $table->integer('add_agent')->nullable();
          $table->integer('add_customer')->nullable();
          $table->string('add_customer_name')->nullable();
          $table->datetime('add_date')->nullable();
          $table->integer('add_pax')->default(0);
          $table->integer('add_unit')->default(0);
          $table->string('add_reference')->nullable();
          $table->string('add_tracking')->nullable();
          $table->string('add_status')->default('active');
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
      Schema::drop('addons');
      Schema::drop('bookings');
      Schema::drop('booking_sources');
    }
}
