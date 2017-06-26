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
        ['cod_group' => 'account','cod_key' => 'cash', 'cod_description' => 'Cash', 'created_by' => 1],
        ['cod_group' => 'account','cod_key' => 'bank1', 'cod_description' => 'Bank 1', 'created_by' => 1],
        ['cod_group' => 'account','cod_key' => 'bank2', 'cod_description' => 'Bank 2', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'cash', 'cod_description' => 'Cash', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'bank', 'cod_description' => 'Bank Transfer', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'agent', 'cod_description' => 'Agent Transfer', 'created_by' => 1],
        ['cod_group' => 'pay_method','cod_key' => 'paypal', 'cod_description' => 'Paypal', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'checkedin', 'cod_description' => 'Checked-In', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'checkedout', 'cod_description' => 'Checked-Out', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'confirmed', 'cod_description' => 'Confirmed', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'hold', 'cod_description' => 'Hold', 'created_by' => 1],
        ['cod_group' => 'book_status','cod_key' => 'cancelled', 'cod_description' => 'Cancelled', 'created_by' => 1],
        ['cod_group' => 'cus_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'cus_status','cod_key' => 'suspended', 'cod_description' => 'Suspended', 'created_by' => 1],
        ['cod_group' => 'rs_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'rs_status','cod_key' => 'inactive', 'cod_description' => 'Inactive', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'active', 'cod_description' => 'Active', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'cancelled', 'cod_description' => 'Cancelled', 'created_by' => 1],
        ['cod_group' => 'add_status','cod_key' => 'completed', 'cod_description' => 'Completed', 'created_by' => 1],
        ['cod_group' => 'rep_status','cod_key' => 'pending', 'cod_description' => 'Pending', 'created_by' => 1],
        ['cod_group' => 'rep_status','cod_key' => 'inprocess', 'cod_description' => 'In-process', 'created_by' => 1],
        ['cod_group' => 'rep_status','cod_key' => 'completed', 'cod_description' => 'Completed', 'created_by' => 1],
        ['cod_group' => 'rep_status','cod_key' => 'error', 'cod_description' => 'With error', 'created_by' => 1],
        ['cod_group' => 'rep_status','cod_key' => 'cancelled', 'cod_description' => 'Cancelled', 'created_by' => 1],
        ['cod_group' => 'rc_type','cod_key' => 'deposit', 'cod_description' => 'Deposit', 'created_by' => 1],
        ['cod_group' => 'rc_type','cod_key' => 'others', 'cod_description' => 'Non-Deposit', 'created_by' => 1],
        ['cod_group' => 'ag_type','cod_key' => 'sales', 'cod_description' => 'Sales', 'created_by' => 1],
        ['cod_group' => 'ag_type','cod_key' => 'agents', 'cod_description' => 'Agents', 'created_by' => 1],
        ['cod_group' => 'ag_type','cod_key' => 'suppliers', 'cod_description' => 'Suppliers', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'tripadvisor', 'cod_description' => 'TripAdvisor', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'website', 'cod_description' => 'Our website', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'google_ads', 'cod_description' => 'Google Ads', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'search_engine', 'cod_description' => 'Search Engine', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'krabi.dir', 'cod_description' => 'Krabi Dir', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'friend', 'cod_description' => 'Friends', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'travel_blogs', 'cod_description' => 'Travel Blogs', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'facebook', 'cod_description' => 'Facebook', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'mag', 'cod_description' => 'Magazine & Newspaper', 'created_by' => 1],
        ['cod_group' => 'book_lead_from','cod_key' => 'others', 'cod_description' => 'Others', 'created_by' => 1],
      ]);
    }
}
