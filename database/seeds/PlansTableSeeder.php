<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('plans')->insert([
        ['pla_id'=>1, 'pla_title' => 'Free','pla_description' => 'Free plan', 'pla_price' => 0],
        ['pla_id'=>2, 'pla_title' => 'Basic','pla_description' => 'Basic plan', 'pla_price' => 200],
      ]);
    }
}
