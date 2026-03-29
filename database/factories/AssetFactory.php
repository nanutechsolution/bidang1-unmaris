<?php

namespace Database\Factories;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'asset_code' => 'UNM-' . $this->faker->unique()->numerify('2026-#####'),
            'name' => $this->faker->randomElement(['Laptop ASUS ROG', 'Proyektor Epson', 'Meja Dosen', 'Kursi Mahasiswa', 'AC Daikin 2PK']),
            'category_id' => AssetCategory::factory(),
            'location_id' => Location::factory(),
            'purchase_date' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'price' => $this->faker->randomFloat(2, 500000, 25000000),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'maintenance', 'disposed']),
            'condition' => $this->faker->randomElement(['good', 'good', 'fair', 'poor']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
