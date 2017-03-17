<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reports', function (Blueprint $table) {
          $table->increments('rep_id')->unsigned();
          $table->string('rep_function');
          $table->integer('rep_tries')->default(0);
          $table->text('rep_filter');
          $table->text('rep_output_path')->nullable();
          $table->string('rep_status')->default('pending');
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
      Schema::dropIfExists('reports');
    }
}
