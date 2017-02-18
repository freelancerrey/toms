<?php

use Illuminate\Database\Seeder;

class PaymentGatewayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_gateways')->insert([
            ['gateway' => 'Authorize.net', 'is_active' => 1],
            ['gateway' => 'Paypal', 'is_active' => 1]
        ]);
    }
}
