<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // bKash, Nagad, Rocket, Card, Bank Transfer
            $table->string('code')->unique(); // bkash, nagad, rocket, card, bank
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // Store payment gateway config
            $table->boolean('is_active')->default(true);
            $table->boolean('is_online')->default(false);
            $table->decimal('charge', 8, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default payment methods
        DB::table('payment_methods')->insert([
            [
                'name' => 'Cash on Delivery',
                'code' => 'cod',
                'description' => 'Pay when you receive the product',
                'is_active' => true,
                'is_online' => false,
                'charge' => 0,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'bKash',
                'code' => 'bkash',
                'description' => 'Pay with bKash mobile banking',
                'is_active' => true,
                'is_online' => true,
                'charge' => 1.5,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Nagad',
                'code' => 'nagad',
                'description' => 'Pay with Nagad mobile banking',
                'is_active' => true,
                'is_online' => true,
                'charge' => 1.5,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Rocket',
                'code' => 'rocket',
                'description' => 'Pay with DBBL Rocket',
                'is_active' => true,
                'is_online' => true,
                'charge' => 1.5,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Credit/Debit Card',
                'code' => 'card',
                'description' => 'Pay with Visa/MasterCard',
                'is_active' => true,
                'is_online' => true,
                'charge' => 2.0,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bank Transfer',
                'code' => 'bank',
                'description' => 'Direct bank transfer',
                'is_active' => true,
                'is_online' => true,
                'charge' => 0,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
