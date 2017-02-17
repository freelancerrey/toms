<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            ['category' => 1, 'status' => 'Unverified', 'is_active' => 1],
            ['category' => 1, 'status' => 'Verifying', 'is_active' => 1],
            ['category' => 1, 'status' => 'Verified', 'is_active' => 1],
            ['category' => 1, 'status' => 'Clarification', 'is_active' => 1],
            ['category' => 1, 'status' => 'Hold', 'is_active' => 1],
            ['category' => 1, 'status' => 'Notes', 'is_active' => 1],
            ['category' => 2, 'status' => 'Requesting Form', 'is_active' => 1],
            ['category' => 2, 'status' => 'Unverified', 'is_active' => 1],
            ['category' => 2, 'status' => 'Verified', 'is_active' => 1],
            ['category' => 2, 'status' => 'Hold', 'is_active' => 1],
            ['category' => 2, 'status' => 'Clarification', 'is_active' => 1],
            ['category' => 2, 'status' => 'Notes', 'is_active' => 1],
            ['category' => 2, 'status' => 'Waiting for Previous Order', 'is_active' => 1],
            ['category' => 2, 'status' => 'For Refund', 'is_active' => 1],
            ['category' => 3, 'status' => 'Verifying ', 'is_active' => 1],
            ['category' => 3, 'status' => 'Verified', 'is_active' => 1],
            ['category' => 3, 'status' => 'Clarification', 'is_active' => 1],
            ['category' => 3, 'status' => 'Asking for Headline', 'is_active' => 1],
            ['category' => 3, 'status' => 'Squeeze Page Done', 'is_active' => 1],
            ['category' => 3, 'status' => 'In Rotator', 'is_active' => 1],
            ['category' => 3, 'status' => 'Waiting for Confirmation', 'is_active' => 1],
            ['category' => 3, 'status' => 'Client Changes', 'is_active' => 1],
            ['category' => 3, 'status' => 'Hold', 'is_active' => 1],
            ['category' => 3, 'status' => 'Notes', 'is_active' => 1],
            ['category' => 3, 'status' => 'For Refund', 'is_active' => 1],
            ['category' => 4, 'status' => 'Running', 'is_active' => 1],
            ['category' => 4, 'status' => 'Clarification', 'is_active' => 1],
            ['category' => 4, 'status' => 'Running More Clicks', 'is_active' => 1],
            ['category' => 4, 'status' => 'Client Changes', 'is_active' => 1],
            ['category' => 4, 'status' => 'Completed', 'is_active' => 1],
            ['category' => 4, 'status' => 'Hold', 'is_active' => 1],
            ['category' => 4, 'status' => 'Notes', 'is_active' => 1],
            ['category' => 4, 'status' => 'Reprocess', 'is_active' => 1],
            ['category' => 4, 'status' => 'For Refund', 'is_active' => 1],
            ['category' => 5, 'status' => 'Successful', 'is_active' => 1],
            ['category' => 5, 'status' => 'Clarification', 'is_active' => 1],
            ['category' => 5, 'status' => 'Complaint/Unseatled', 'is_active' => 1],
            ['category' => 5, 'status' => 'Refunded', 'is_active' => 1],
            ['category' => 5, 'status' => 'Notes', 'is_active' => 1],
            ['category' => 6, 'status' => 'Failed Payment', 'is_active' => 1],
            ['category' => 6, 'status' => 'Refunded', 'is_active' => 1],
            ['category' => 6, 'status' => 'Ignore', 'is_active' => 1],
            ['category' => 6, 'status' => 'Notes', 'is_active' => 1]
        ]);
    }
}
