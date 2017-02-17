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
            ['type' => 'Optin Rate Guaranteed', 'is_active' => 1],
            ['type' => 'Direct To Client Page', 'is_active' => 1],
            ['type' => 'Pipeline Subscription', 'is_active' => 1]
        ]);
    }
}
