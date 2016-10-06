<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Memo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('memo_customer', function (Blueprint $table) {
          $table->increments('mem_id');
          $table->integer('mem_for')->unsigned();
          $table->text('mem_description');
          $table->integer('created_by')->unsigned();
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
        Schema::drop('memo_customer');
    }
}
