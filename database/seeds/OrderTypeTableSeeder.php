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
            ['id' => 4, 'type' => 'Unknown', 'is_active' => 1],
            ['id' => 1, 'type' => 'Optin Rate Guaranteed', 'is_active' => 1],
            ['id' => 2, 'type' => 'Direct To Client Page', 'is_active' => 1],
            ['id' => 3, 'type' => 'Pipeline Subscription', 'is_active' => 1]
        ]);
    }
}
