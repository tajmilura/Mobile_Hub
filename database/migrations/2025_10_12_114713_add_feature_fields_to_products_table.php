<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->boolean('is_featured')->default(false)->after('water_resistance');
        $table->boolean('is_new_arrival')->default(false)->after('is_featured');
        $table->boolean('is_hot_deal')->default(false)->after('is_new_arrival');
        $table->decimal('discount_price', 10, 2)->nullable()->after('price');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['is_featured', 'is_new_arrival', 'is_hot_deal', 'discount_price']);
    });
}

};
