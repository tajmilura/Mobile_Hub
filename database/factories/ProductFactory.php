<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Use real foreign keys if Category and Brand models exist
        // Note: Ensure Category and Brand tables are seeded first.
        $categoryId = Category::inRandomOrder()->first()?->id ?? 1;
        $brandId = Brand::inRandomOrder()->first()?->id ?? 1;

        $price = $this->faker->randomFloat(2, 50, 1000);
        $discountPrice = $price * 0.8; // 20% discount

        $mainImagePath = 'uploads/products/main_image/demo_product.jpg';
        // ------------------------------------

        return [
            // Foreign Keys
            'category_id' => $categoryId,
            'brand_id' => $brandId,

            // Basic Info
            'name' => $this->faker->unique()->words(3, true) . ' ' . $this->faker->suffix(),
            'description' => $this->faker->paragraph(3),
            'price' => $price,
            'discount_price' => $discountPrice,
            'discount_start' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'discount_end' => $this->faker->dateTimeBetween('now', '+1 month'),
            'stock' => $this->faker->numberBetween(0, 100),

            // Images and Media (Updated)
            'image' => $mainImagePath,
            'gallery' => null,
            // 'video' => null,

            // Specifications
            'ram' => $this->faker->randomElement(['4GB', '8GB', '12GB', '16GB']),
            'storage' => $this->faker->randomElement(['128GB', '256GB', '512GB', '1TB']),
            'processor' => $this->faker->randomElement(['Snapdragon 888', 'Apple A15 Bionic', 'Exynos 2200']),
            'os' => $this->faker->randomElement(['Android 14', 'iOS 17', 'Windows 11']),
            'battery' => $this->faker->randomElement(['4500mAh', '5000mAh', '6000mAh']),
            'charging' => $this->faker->randomElement(['65W Fast Charge', '30W Wireless', '120W Super Fast']),
            'display' => $this->faker->randomElement(['6.7" AMOLED', '6.1" Liquid Retina', '6.5" Super AMOLED']),
            'resolution' => $this->faker->randomElement(['2400x1080', '2532x1170', '1920x1080']),
            'camera' => $this->faker->randomElement(['108MP Quad', '50MP Dual', '64MP Triple']),
            'front_camera' => $this->faker->randomElement(['16MP', '12MP', '32MP']),
            'network' => $this->faker->randomElement(['5G', 'LTE', '4G']),
            'sim' => $this->faker->randomElement(['Dual SIM', 'Single SIM + eSIM']),
            'build' => $this->faker->randomElement(['Glass/Aluminum', 'Plastic', 'Ceramic']),
            'weight' => $this->faker->randomFloat(2, 150, 250) . 'g',
            'dimensions' => $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(2) . 'x' . $this->faker->randomFloat(1, 7, 10) . 'mm',

            // Other Attributes (Casting is handled by the model, storing as array/string here)
            'colors' => json_encode($this->faker->randomElements(['Black', 'White', 'Blue', 'Red', 'Green'], 2)),
            'fingerprint' => $this->faker->boolean(),
            'water_resistance' => $this->faker->randomElement(['IP68', 'IP67', null]),
            'bluetooth' => $this->faker->randomElement(['v5.2', 'v5.3', 'v5.0']),
            'wifi' => $this->faker->randomElement(['Wi-Fi 6', 'Wi-Fi 5', 'Wi-Fi 7']),
            'usb' => $this->faker->randomElement(['USB-C', 'Lightning']),
            'audio' => $this->faker->randomElement(['Stereo Speakers', 'Mono Speaker']),
            'sensors' => $this->faker->randomElement(['Accelerometer, Gyro, Compass', 'Proximity, Ambient Light']),
            'release_date' => $this->faker->date(),

            // Flags
            'is_featured' => $this->faker->boolean(30),
            'is_new_arrival' => $this->faker->boolean(70),
            'is_hot_deal' => $this->faker->boolean(40),

            // Identifiers and Warranty
            'warranty' => $this->faker->randomElement(['1 Year Standard', '2 Years Extended', '90 Days Limited']),
            'tags' => json_encode($this->faker->words(4)),
            'sku' => $this->faker->unique()->ean8(),
            'barcode' => $this->faker->unique()->ean13(),
        ];
    }
}
