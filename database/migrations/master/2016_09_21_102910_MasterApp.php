<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('merchants', function (Blueprint $table) {
          $table->increments('mer_id');
          $table->string('mer_name');
          $table->string('mer_country');
          $table->integer('mer_owner');
          $table->string('mer_connection');
          $table->text('mer_setting')->nullable();
          $table->string('mer_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('merchant_users', function (Blueprint $table) {
          $table->increments('mus_id');
          $table->integer('mus_merchant');
          $table->integer('mus_user');
          $table->string('mus_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('plans', function (Blueprint $table) {
          $table->increments('pla_id');
          $table->string('pla_title');
          $table->text('pla_description');
          $table->decimal('pla_price', 10, 2)->default(0);
          $table->string('pla_status')->default('active');
          $table->timestamps();
      });

      Schema::create('subscriptions', function (Blueprint $table) {
          $table->increments('sub_id');
          $table->integer('sub_merchant');
          $table->integer('sub_plan');
          $table->string('sub_status')->default('active');
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
      Schema::drop('subscriptions');
      Schema::drop('plans');
      Schema::drop('merchants');
    }
}
