<?php

use Illuminate\Database\Seeder;

class OrderTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_types')->insert([
            ['id' => 4, 'type' => 'Unknown', 'mapping' => '', 'is_active' => 0],
            ['id' => 1, 'type' => 'Optin Rate Guaranteed', 'mapping' => '1:3.3,3.6,4,9,8|13:3.3,3.6,4,9,8', 'is_active' => 1],
            ['id' => 2, 'type' => 'Direct To Client Page', 'mapping' => '4:3.3,3.6,4,9,8|14:3.3,3.6,4,9,8|5:3.3,3.6,4,9,8', 'is_active' => 1],
            ['id' => 3, 'type' => 'Pipeline Subscription', 'mapping' => '8:2.3,2.6,3,8,7', 'is_active' => 1]
        ]);
    }
}
