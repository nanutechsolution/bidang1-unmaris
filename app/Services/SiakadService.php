<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * SIAKAD SERVICE - CORE INTEGRATION
 * Dirancang untuk skalabilitas jangka panjang dan performa tinggi.
 * Menangani autentikasi SSO, sinkronisasi profil, dan manajemen unit.
 */
class SiakadService
{
    /**
     * URL Dasar API SIAKAD UNMARIS
     */
    protected string $baseUrl;

    /**
     * Key API untuk keamanan jabat tangan antar aplikasi
     */
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.siakad.url', 'https://siakad.unmarissumba.ac.id/api');
        $this->apiKey = config('services.siakad.key');
    }

    /**
     * Proses Autentikasi Multi-Step: Login -> Get Profile -> Sync Local
     */
    public function authenticate(string $username, string $password): bool
    {
        try {
            // 1. Tahap Autentikasi Kredensial (Sanctum Login)
            $loginResponse = Http::withHeaders([
                'Accept' => 'application/json',
                'X-SIMA-KEY' => $this->apiKey,
            ])->timeout(10)->post("{$this->baseUrl}/v1/login", [
                'username' => $username,
                'password' => $password,
            ]);

            if (!$loginResponse->successful()) {
                Log::warning("Gagal login SIAKAD untuk user: {$username}. Status: " . $loginResponse->status());
                return false;
            }

            $token = $loginResponse->json()['token'];

            // 2. Tahap Pengambilan Profil (Bearer Token)
            // Gunakan caching singkat agar jika user login berulang kali dalam waktu dekat tidak membebani API
            $profileData = Cache::remember("siakad_profile_{$username}", 300, function () use ($token) {
                $response = Http::withToken($token)
                    ->withHeaders(['Accept' => 'application/json'])
                    ->timeout(10)
                    ->get("{$this->baseUrl}/v1/user/me");

                return $response->successful() ? $response->json()['data'] : null;
            });

            if ($profileData) {
                $this->syncUser($profileData);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Koneksi API SIAKAD Terputus: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sinkronisasi Data SIAKAD ke Database Lokal
     * Memastikan integritas data antara sistem akademik pusat dan Bidang 1.
     */
    protected function syncUser(array $data): void
    {
        // Sinkronisasi Unit/Departemen secara otomatis
        $unit = Cache::remember("unit_name_" . Str::slug($data['department']), 3600, function () use ($data) {
            return Unit::firstOrCreate(
                ['name' => $data['department']],
                ['type' => 'prodi']
            );
        });

        // Logika Penentuan Role Dinamis
        // Untuk 20 tahun ke depan, disarankan memindahkan daftar NIDN Pimpinan ke tabel konfigurasi/database
        $localRole = $this->determineRole($data);

        User::updateOrCreate(
            ['email' => $data['identifier'] . '@unmaris.ac.id'], // Email berbasis NIDN sebagai ID unik
            [
                'name' => $data['name'],
                'password' => Hash::make(Str::random(64)), // Password lokal sangat panjang untuk keamanan ekstra
                'role' => $localRole,
                'unit_id' => $unit->id,
            ]
        );
    }

    /**
     * Menentukan Role berdasarkan data SIAKAD dan aturan bisnis kampus
     */
    protected function determineRole(array $data): string
    {
        // Ambil daftar NIDN Pimpinan dari config atau database di masa depan
        $pimpinanNidn = config('app.pimpinan_nidn', []);

        if (in_array($data['identifier'], $pimpinanNidn) || $data['role'] === 'admin') {
            return 'rektorat';
        }

        return 'prodi';
    }
}
