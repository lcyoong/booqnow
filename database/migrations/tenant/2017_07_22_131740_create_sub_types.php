<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('resource_sub_types', function (Blueprint $table) {
          $table->increments('rsty_id');
          $table->integer('rsty_type');
          $table->string('rsty_code')->nullable();
          $table->string('rsty_name');
          $table->string('rsty_status')->default('active');
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
      Schema::dropIfExists('resource_sub_types');
    }
}
