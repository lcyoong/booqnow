<?php

use Illuminate\Database\Seeder;

class OjhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement("ALTER TABLE agents AUTO_INCREMENT = 100001;");
      DB::statement("ALTER TABLE customers AUTO_INCREMENT = 100001;");
      DB::statement("ALTER TABLE bookings AUTO_INCREMENT = 100001;");
      DB::statement("ALTER TABLE bills AUTO_INCREMENT = 100001;");
      DB::statement("ALTER TABLE receipts AUTO_INCREMENT = 100001;");

      DB::table('resource_types')->insert([
        ['rty_id'=> 1, 'rty_accounting' => 1, 'rty_pos' => false, 'rty_seasonal' => true, 'rty_master' => true, 'rty_code' => 'room', 'rty_name' => 'Room', 'rty_plural' => 'Rooms', 'rty_price' => 0, 'created_by' => 1],
        ['rty_id'=> 2, 'rty_accounting' => 2, 'rty_pos' => false, 'rty_seasonal' => false, 'rty_master' => false, 'rty_code' => 'tour','rty_name' => 'Tour', 'rty_plural' => 'Tours', 'rty_price' => 0, 'created_by' => 1],
        ['rty_id'=> 3, 'rty_accounting' => 1, 'rty_pos' => true, 'rty_seasonal' => false, 'rty_master' => false, 'rty_code' => 'fnb', 'rty_name' => 'F&B', 'rty_plural' => 'F&B', 'rty_price' => 0, 'created_by' => 1],
        ['rty_id'=> 4, 'rty_accounting' => 1, 'rty_pos' => false, 'rty_seasonal' => false, 'rty_master' => false, 'rty_code' => 'transfer', 'rty_name' => 'Transfer', 'rty_plural' => 'Transfers', 'rty_price' => 0, 'created_by' => 1],
        ['rty_id'=> 5, 'rty_accounting' => 1, 'rty_pos' => false, 'rty_seasonal' => false, 'rty_master' => false, 'rty_code' => 'other', 'rty_name' => 'Other', 'rty_plural' => 'Others', 'rty_price' => 0, 'created_by' => 1],
      ]);

      DB::table('resources')->insert([
        ['rs_name'=> 'Halfmoon (TH1)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 1, 'created_by' => 1],
        ['rs_name'=> 'Happy Nest (TH2)', 'rs_type' => 1,'rs_price' => 3100, 'rs_order' => 2, 'created_by' => 1],
        ['rs_name'=> 'Romance (TH3)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 3, 'created_by' => 1],
        ['rs_name'=> 'Forest (TH4)', 'rs_type' => 1,'rs_price' => 2200, 'rs_order' => 4, 'created_by' => 1],
        ['rs_name'=> 'Starlight (TH5)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 5, 'created_by' => 1],
        ['rs_name'=> 'Sunshine (TH6)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 6, 'created_by' => 1],
        ['rs_name'=> 'Ginga (TH7)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 7, 'created_by' => 1],
        ['rs_name'=> 'Liana (TH8)', 'rs_type' => 1,'rs_price' => 2300, 'rs_order' => 8, 'created_by' => 1],
        ['rs_name'=> 'Mango House', 'rs_type' => 1,'rs_price' => 1500, 'rs_order' => 9, 'created_by' => 1],
        ['rs_name'=> 'Mango Rambutan', 'rs_type' => 1,'rs_price' => 2100, 'rs_order' => 10, 'created_by' => 1],
        ['rs_name'=> 'Cliff House 1', 'rs_type' => 1,'rs_price' => 800, 'rs_order' => 11, 'created_by' => 1],
        ['rs_name'=> 'Cliff House 2', 'rs_type' => 1,'rs_price' => 800, 'rs_order' => 12, 'created_by' => 1],
        ['rs_name'=> 'Thai House', 'rs_type' => 1,'rs_price' => 1500, 'rs_order' => 13, 'created_by' => 1],
        ['rs_name'=> 'Bungalow River 1 (R1)', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 14, 'created_by' => 1],
        ['rs_name'=> 'Bungalow River 2 (R2)', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 15, 'created_by' => 1],
        ['rs_name'=> 'Bungalow Jungle 1 (JH1)', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 16, 'created_by' => 1],
        ['rs_name'=> 'Bungalow Jungle 2 (JH2)', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 17, 'created_by' => 1],
        ['rs_name'=> 'Bungalow Garden', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 18, 'created_by' => 1],
        ['rs_name'=> 'Bungalow Nature', 'rs_type' => 1,'rs_price' => 1100, 'rs_order' => 19, 'created_by' => 1],
        ['rs_name'=> 'Jungle Treehouse Park View', 'rs_type' => 1,'rs_price' => 2200, 'rs_order' => 20, 'created_by' => 1],
        ['rs_name'=> 'Hideaway Treehouse (TH9)', 'rs_type' => 1,'rs_price' => 2200, 'rs_order' => 21, 'created_by' => 1],
      ]);

      DB::table('resources')->insert([
        ['rs_name'=> 'Tent 1', 'rs_type' => 1,'rs_price' => 500, 'rs_order' => 22, 'rs_label' => 'tent', 'created_by' => 1],
        ['rs_name'=> 'Tent 2', 'rs_type' => 1,'rs_price' => 500, 'rs_order' => 23, 'rs_label' => 'tent', 'created_by' => 1],
        ['rs_name'=> 'Tent 3', 'rs_type' => 1,'rs_price' => 500, 'rs_order' => 24, 'rs_label' => 'tent', 'created_by' => 1],
      ]);

      $this->call(OjhSeasonSeeder::class);
    }
}
