<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use App\Models\AssetTracking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@unmaris.ac.id',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staf Sarpras',
            'email' => 'operator@unmaris.ac.id',
            'password' => bcrypt('password123'),
            'role' => 'operator',
        ]);

        User::create([
            'name' => 'Rektor UNMARIS',
            'email' => 'rektor@unmaris.ac.id',
            'password' => bcrypt('password123'),
            'role' => 'viewer',
        ]);
        // 1. Buat Akun Admin IT UNMARIS
        $admin = User::firstOrCreate(
            ['email' => 'admin@unmaris.ac.id'],
            [
                'name' => 'Administrator Aset',
                'password' => Hash::make('password123'), // Default password
            ]
        );


        // 2. Buat Kategori Master secara statis agar relevan
        $categories = collect([
            ['code' => 'ELK', 'name' => 'Elektronik & IT'],
            ['code' => 'MBL', 'name' => 'Mebel & Furnitur'],
            ['code' => 'KND', 'name' => 'Kendaraan Operasional'],
        ])->map(fn($cat) => AssetCategory::firstOrCreate(['code' => $cat['code']], $cat));

        // 3. Buat Lokasi Master secara statis
        $locations = collect([
            ['building' => 'Gedung Rektorat', 'room_number' => 'R-101', 'name' => 'Ruang Rektor'],
            ['building' => 'Fakultas Teknik', 'room_number' => 'T-201', 'name' => 'Lab Komputer A'],
            ['building' => 'Perpustakaan', 'room_number' => 'P-001', 'name' => 'Ruang Baca Utama'],
        ])->map(fn($loc) => Location::firstOrCreate(['room_number' => $loc['room_number']], $loc));

        // 4. Generate 250 Aset secara random, di-assign ke kategori & lokasi yang sudah dibuat
        Asset::factory(250)->create([
            'category_id' => fn() => $categories->random()->id,
            'location_id' => fn() => $locations->random()->id,
        ])->each(function ($asset) use ($admin) {
            // 5. Otomatis buat Tracking "Created" untuk setiap aset
            AssetTracking::create([
                'asset_id' => $asset->id,
                'user_id' => $admin->id,
                'action' => 'created',
                'notes' => 'Aset diimpor dari sistem awal',
                'previous_state' => null,
                'new_state' => $asset->toArray(),
            ]);
        });
    }
}
