<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuditTrail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('audit_trails', function (Blueprint $table) {
        $table->increments('au_id')->unsigned();
        $table->string('au_mode');
        $table->string('au_model_type');
        $table->integer('au_model_id')->unsigned();
        $table->text('au_data');
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
      Schema::drop('audit_trails');
    }
}
