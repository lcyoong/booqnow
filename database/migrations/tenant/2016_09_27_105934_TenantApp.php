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
      Schema::create('codes', function (Blueprint $table) {
          $table->increments('cod_id');
          $table->string('cod_group');
          $table->string('cod_key');
          $table->string('cod_description');
          $table->integer('cod_order')->default(0);
          $table->string('cod_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resource_types', function (Blueprint $table) {
          $table->increments('rty_id');
          $table->integer('rty_accounting')->unsigned()->default(1);
          $table->boolean('rty_master')->default(false);
          $table->boolean('rty_pos')->default(false);
          $table->boolean('rty_seasonal')->default(false);
          $table->string('rty_code')->nullable();
          $table->string('rty_name');
          $table->string('rty_plural');
          $table->decimal('rty_price', 10, 2)->default(0);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resources', function (Blueprint $table) {
          $table->increments('rs_id');
          $table->string('rs_name');
          $table->text('rs_description')->nullable();
          $table->integer('rs_type');
          $table->decimal('rs_price', 10, 2)->default(0);
          $table->integer('rs_order')->default(0);
          $table->string('rs_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resource_maintenances', function (Blueprint $table) {
          $table->increments('rm_id');
          $table->integer('rm_resource')->unsigned();
          $table->datetime('rm_from');
          $table->datetime('rm_to');
          $table->string('rm_description');
          $table->string('rm_status')->default('active');
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
          $table->string('cus_first_name');
          $table->string('cus_last_name');
          $table->string('cus_email');
          $table->string('cus_country');
          $table->string('cus_contact1')->nullable();
          $table->string('cus_contact2')->nullable();
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
      Schema::drop('resource_maintenance');
      Schema::drop('resources');
      Schema::drop('resource_types');
      Schema::drop('customers');
      Schema::drop('codes');
      Schema::drop('customer_groups');
    }
}
