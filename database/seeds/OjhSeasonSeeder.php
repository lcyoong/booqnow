<?php

use Illuminate\Database\Seeder;

class OjhSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('seasons')->insert([
        ['sea_id'=> 1, 'sea_from' => '2017-07-01', 'sea_to' => '2017-08-31', 'sea_name' => 'High season 1', 'created_by' => 1],
        ['sea_id'=> 2, 'sea_from' => '2017-11-01', 'sea_to' => '2018-04-15', 'sea_name' => 'High season 2', 'created_by' => 1],
      ]);
    }
}
