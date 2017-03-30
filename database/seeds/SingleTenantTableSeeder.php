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
        ['id'=>1, 'name' => 'Superman','email' => 'lcyoong@gmail.com', 'password' => bcrypt('111111'), 'api_token' => str_random(60)],
        ['id'=>2, 'name' => 'Owner','email' => config('myapp.admin_email'), 'password' => bcrypt('111111'), 'api_token' => str_random(60)],
      ]);

      DB::table('merchants')->insert([
        ['mer_id'=>1, 'mer_name' => config('myapp.client_name'),'mer_country' => config('myapp.base_country'), 'mer_owner' => 1, 'created_by' => 1, 'mer_connection' => 'default'],
      ]);

      DB::table('subscriptions')->insert([
        ['sub_id'=>1, 'sub_merchant' => 1, 'sub_plan' => 1, 'created_by' => 1],
      ]);

      DB::table('merchant_users')->insert([
        ['mus_id'=>1, 'mus_merchant' => 1,'mus_user' => 1, 'created_by' => 1],
        ['mus_id'=>2, 'mus_merchant' => 1,'mus_user' => 2, 'created_by' => 1],
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

      DB::table('roles')->insert([
        ['id'=>1, 'name' => 'super_admin', 'display_name' => 'Super Admin'],
        ['id'=>2, 'name' => 'op_admin', 'display_name' => 'Op Admin'],
        ['id'=>3, 'name' => 'front_end', 'display_name' => 'Front End Staff'],
        ['id'=>4, 'name' => 'accounts', 'display_name' => 'Accounts'],
      ]);

      DB::table('permissions')->insert([
        ['id'=>1, 'name' => 'manage_user', 'display_name' => 'Manage Users'],
        ['id'=>2, 'name' => 'manage_role', 'display_name' => 'Manage Roles'],
        ['id'=>3, 'name' => 'manage_permission', 'display_name' => 'Manage Permissions'],
        ['id'=>4, 'name' => 'booking', 'display_name' => 'Bookings'],
        ['id'=>5, 'name' => 'bill', 'display_name' => 'Bills'],
        ['id'=>6, 'name' => 'payment', 'display_name' => 'Payments'],
        ['id'=>7, 'name' => 'customer', 'display_name' => 'Customers'],
        ['id'=>8, 'name' => 'resource', 'display_name' => 'Resources'],
        ['id'=>9, 'name' => 'report', 'display_name' => 'Reports'],
      ]);

      DB::table('role_user')->insert([
        ['user_id' => 1, 'role_id'=>1],
        ['user_id' => 2, 'role_id'=>2],
      ]);

      DB::table('permission_role')->insert([
        ['role_id' => 2, 'permission_id'=>1],
        ['role_id' => 2, 'permission_id'=>4],
        ['role_id' => 2, 'permission_id'=>5],
        ['role_id' => 2, 'permission_id'=>6],
        ['role_id' => 2, 'permission_id'=>7],
        ['role_id' => 2, 'permission_id'=>8],
        ['role_id' => 2, 'permission_id'=>9],

        ['role_id' => 3, 'permission_id'=>4],
        ['role_id' => 3, 'permission_id'=>5],
        ['role_id' => 3, 'permission_id'=>6],
        ['role_id' => 3, 'permission_id'=>7],
      ]);

    }
}
