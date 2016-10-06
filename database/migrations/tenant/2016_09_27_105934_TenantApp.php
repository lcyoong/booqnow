<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('resource_types', function (Blueprint $table) {
          $table->increments('rty_id');
          $table->string('rty_name');
          $table->decimal('rty_price', 10, 2)->default(0);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resources', function (Blueprint $table) {
          $table->increments('rs_id');
          $table->string('rs_name');
          $table->integer('rs_type');
          $table->decimal('rs_price', 10, 2)->default(0);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('customer_groups', function (Blueprint $table) {
          $table->increments('cug_id');
          $table->string('cug_name');
          $table->string('cug_description');
          $table->string('cug_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('customers', function (Blueprint $table) {
          $table->increments('cus_id');
          $table->string('cus_name');
          $table->string('cus_email');
          $table->string('cus_contact1');
          $table->string('cus_contact2');
          $table->integer('cus_group')->unsigned()->nullable();
          $table->text('cus_address')->nullable();
          $table->boolean('cus_ignore')->default(0);
          $table->boolean('cus_blacklist')->default(0);
          $table->string('cus_status')->default('active');
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
      Schema::drop('resource_types');
      Schema::drop('resources');
      Schema::drop('customers');
      Schema::drop('customer_categories');
    }
}
