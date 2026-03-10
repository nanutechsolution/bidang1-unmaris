<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Data User (Dummy untuk Testing)
        $admin = User::firstOrCreate(
            ['email' => 'admin@unmaris.ac.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );

        $dosen = User::firstOrCreate(
            ['email' => 'dosen@unmaris.ac.id'],
            [
                'name' => 'Dosen Prodi Keperawatan',
                'password' => bcrypt('password123'),
            ]
        );

        // 2. Data Unit / Prodi
        $units = [
            ['name' => 'Warek 1', 'type' => 'rektorat'],
            ['name' => 'Pusda', 'type' => 'pusat'],
            ['name' => 'Puslit', 'type' => 'pusat'],
            ['name' => 'Prodi S1 Keperawatan', 'type' => 'prodi'],
            ['name' => 'Prodi S1 Farmasi', 'type' => 'prodi'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['name' => $unit['name']], $unit);
        }

        // 3. Data Kategori Dokumen
        $categories = [
            ['name' => 'RPS', 'description' => 'Rencana Pembelajaran Semester'],
            ['name' => 'SK Mengajar', 'description' => 'Surat Keputusan Mengajar Dosen'],
            ['name' => 'Borang Akreditasi', 'description' => 'Dokumen pendukung akreditasi BAN-PT/LAM-PTKes'],
        ];

        foreach ($categories as $category) {
            DocumentCategory::firstOrCreate(['name' => $category['name']], $category);
        }

        // 4. Data Dummy Dokumen (Agar tabel tidak kosong)
        Document::firstOrCreate(
            ['title' => 'RPS Keperawatan Medikal Bedah 2026'],
            [
                'unit_id' => Unit::where('name', 'Prodi S1 Keperawatan')->first()->id,
                'document_category_id' => DocumentCategory::where('name', 'RPS')->first()->id,
                'user_id' => $dosen->id,
                'file_path' => 'dummy-file.pdf', // Hanya nama file dummy sementara
                'description' => 'RPS Semester Ganjil 2026/2027',
                'status' => 'submitted',
            ]
        );
    }
}
