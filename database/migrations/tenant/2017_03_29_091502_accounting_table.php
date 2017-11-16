<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('expense_categories', function (Blueprint $table) {
          $table->increments('exc_id');
          $table->string('exc_name');
          $table->string('exc_label')->nullable();
          $table->string('exc_status')->default('active');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('expenses', function (Blueprint $table) {
          $table->increments('exp_id');
          $table->date('exp_date');
          $table->string('exp_description');
          $table->integer('exp_category');
          $table->string('exp_account');
          $table->text('exp_memo')->nullable();
          $table->decimal('exp_amount', 15, 2)->default(0);
          $table->string('exp_status')->default('active');
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
      Schema::dropIfExists('expenses');
      Schema::dropIfExists('expense_categories');
    }
}
