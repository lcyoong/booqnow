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
        ['cod_group' => 'book_status','cod_key' => 'checkedin', 'cod_description' => 'Checked-In', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'checkedout', 'cod_description' => 'Checked-Out', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'hold', 'cod_description' => 'Hold', 'created_by' => 1],
        ['cod_group' => 'cus_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'cus_status','cod_key' => 'suspended', 'cod_description' => 'Suspended', 'created_by' => 1],
        ['cod_group' => 'rs_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'rs_status','cod_key' => 'inactive', 'cod_description' => 'Inactive', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'cancelled', 'cod_description' => 'Cancelled', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'completed', 'cod_description' => 'Completed', 'created_by' => 1],
      ]);
    }
}
