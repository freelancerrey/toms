<?php

use Illuminate\Database\Seeder;

class StatusCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_categories')->insert([
            ['id' => 1, 'category' => 'Payment', 'is_active' => 1],
            ['id' => 2, 'category' => 'Order', 'is_active' => 1],
            ['id' => 3, 'category' => 'Process', 'is_active' => 1],
            ['id' => 4, 'category' => 'Traffic', 'is_active' => 1],
            ['id' => 5, 'category' => 'Done', 'is_active' => 1],
            ['id' => 6, 'category' => 'Discard', 'is_active' => 1]
        ]);
    }
}
