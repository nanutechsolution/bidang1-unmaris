<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'building' => $this->faker->randomElement(['Gedung Rektorat', 'Fakultas Teknik', 'Fakultas Ekonomi', 'Perpustakaan Utama']),
            'room_number' => $this->faker->bothify('R-###'),
            'name' => $this->faker->randomElement(['Ruang Dosen', 'Lab Komputer', 'Ruang Kelas', 'Gudang', 'Ruang Rapat']),
        ];
    }
}