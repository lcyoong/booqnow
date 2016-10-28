<?php

use Illuminate\Database\Seeder;

class CodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('codes')->insert([
        ['cod_group' => 'pay_method','cod_key' => 'cash', 'cod_description' => 'Cash', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'tt', 'cod_description' => 'Transfer', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'ccdc', 'cod_description' => 'Credit/Debit Card', 'created_by' => 1],
      ]);
    }
}
