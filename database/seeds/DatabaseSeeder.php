<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrderTypeTableSeeder::class);
        $this->call(StatusCategoryTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(PaymentGatewayTableSeeder::class);
    }
}
