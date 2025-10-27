<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        // Faker ব্যবহার করে 20 demo brands বানানো
        \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            Brand::create([
                'name' => 'Demo Brand ' . $i,
                'brand_icon' => null, // চাইলে icon path দিতে পারো
            ]);
        }
    }
}
