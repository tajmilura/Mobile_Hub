<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run()
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'description' => 'Welcome discount 10% off',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 50,
            'max_discount' => 20,
            'usage_limit' => 100,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'is_active' => true
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'description' => 'Free shipping on orders above $100',
            'type' => 'fixed',
            'value' => 10,
            'min_order_amount' => 100,
            'usage_limit' => 50,
            'start_date' => now(),
            'end_date' => now()->addDays(15),
            'is_active' => true
        ]);

        Coupon::create([
            'code' => 'SAVE25',
            'description' => '25% off on all orders',
            'type' => 'percentage',
            'value' => 25,
            'min_order_amount' => 75,
            'max_discount' => 50,
            'usage_limit' => null,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'is_active' => true
        ]);
    }
}