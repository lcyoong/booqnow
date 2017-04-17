<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('accounting', function (Blueprint $table) {
          $table->increments('acc_id')->unsigned();
          $table->string('acc_name');
          $table->string('acc_bill_description');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('bills', function (Blueprint $table) {
          $table->increments('bil_id');
          $table->integer('bil_accounting')->default(1);
          $table->integer('bil_customer')->nullable();
          $table->string('bil_customer_name');
          $table->integer('bil_booking')->nullable();
          $table->string('bil_description')->nullable();
          $table->date('bil_date');
          $table->date('bil_due_date');
          $table->decimal('bil_gross', 15, 2)->default(0);
          $table->decimal('bil_tax', 15, 2)->default(0);
          $table->decimal('bil_paid', 15, 2)->default(0);
          $table->string('bil_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('bill_items', function (Blueprint $table) {
          $table->increments('bili_id');
          $table->integer('bili_bill');
          $table->string('bili_description')->nullable();
          $table->integer('bili_resource')->nullable();
          $table->decimal('bili_unit_price', 15, 2)->default(0);
          $table->integer('bili_unit')->default(0);
          $table->decimal('bili_gross', 15, 2)->default(0);
          $table->decimal('bili_tax', 15, 2)->default(0);
          $table->integer('bili_order')->default(0);
          $table->string('bili_status')->default('active');
          $table->boolean('bili_active')->default(1);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('receipts', function (Blueprint $table) {
          $table->increments('rc_id');
          $table->integer('rc_customer')->nullable();
          $table->integer('rc_bill');
          $table->date('rc_date');
          $table->decimal('rc_amount', 15, 2)->default(0);
          $table->string('rc_remark')->nullable();
          $table->string('rc_intremark')->nullable();
          $table->string('rc_reference')->nullable();
          $table->string('rc_method');
          $table->string('rc_type');
          $table->string('rc_status')->default('active');
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
        Schema::drop('bill_items');

        Schema::drop('bills');
    }
}
