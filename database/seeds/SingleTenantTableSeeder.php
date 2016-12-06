<?php

use Illuminate\Database\Seeder;

class SingleTenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('plans')->insert([
        ['pla_id'=>1, 'pla_title' => 'Free Lifetime','pla_description' => 'Lifetime plan', 'pla_price' => 0],
      ]);

      DB::table('users')->insert([
        ['id'=>1, 'name' => 'Owner','email' => config('myapp.admin_email'), 'password' => bcrypt('111111'), 'api_token' => str_random(60)],
      ]);

      DB::table('merchants')->insert([
        ['mer_id'=>1, 'mer_name' => config('myapp.client_name'),'mer_country' => config('myapp.base_country'), 'mer_owner' => 1, 'created_by' => 1, 'mer_connection' => 'default'],
      ]);

      DB::table('subscriptions')->insert([
        ['sub_id'=>1, 'sub_merchant' => 1, 'sub_plan' => 1, 'created_by' => 1],
      ]);

      DB::table('merchant_users')->insert([
        ['mus_id'=>1, 'mus_merchant' => 1,'mus_user' => 1, 'created_by' => 1],
      ]);

      DB::table('accounting')->insert([
        ['acc_id'=>1, 'acc_name' => 'Default', 'acc_bill_description' => 'Accommodation bill', 'created_by' => 1],
        ['acc_id'=>2, 'acc_name' => 'Alternative', 'acc_bill_description' => 'Tour bill', 'created_by' => 1],
      ]);

      DB::table('booking_sources')->insert([
        ['bs_id'=>1, 'bs_description' => 'Online', 'created_by' => 1],
        ['bs_id'=>2, 'bs_description' => 'Walk-in', 'created_by' => 1],
        ['bs_id'=>3, 'bs_description' => 'Agent', 'created_by' => 1],
      ]);

    }
}
