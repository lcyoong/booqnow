<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('seasons', function (Blueprint $table) {
          $table->increments('sea_id')->unsigned();
          $table->date('sea_from');
          $table->date('sea_to');
          $table->string('sea_name');
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resource_pricings', function (Blueprint $table) {
          $table->increments('rpr_id')->unsigned();
          $table->integer('rpr_resource')->unsigned();
          $table->integer('rpr_season')->unsigned();
          // $table->integer('rpr_from')->unsigned()->default(0);
          // $table->integer('rpr_to')->unsigned()->default(0);
          $table->decimal('rpr_price', 15, 2)->default(0);
          $table->integer('created_by');
          $table->timestamps();
      });

      Schema::create('resource_pricing_tiers', function (Blueprint $table) {
          $table->increments('rpt_id')->unsigned();
          $table->integer('rpt_pricing')->unsigned();
          $table->integer('rpt_from')->unsigned()->default(0);
          $table->integer('rpt_to')->unsigned()->default(0);
          $table->decimal('rpt_price', 15, 2)->default(0);
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
      Schema::drop('resource_pricing_tiers');

      Schema::drop('resource_pricings');

      Schema::drop('seasons');
    }
}
