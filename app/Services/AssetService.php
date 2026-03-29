<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AssetService
{
    /**
     * Menyimpan aset baru dan mencatat history (Audit Trail).
     * * @throws Throwable
     */
    public function createAsset(array $data): Asset
    {
        return DB::transaction(function () use ($data) {
            // 1. Generate kode aset jika tidak diberikan (contoh format: UNM-TAHUN-KODEKATEGORI-RANDOM)
            $assetCode = $data['asset_code'] ?? $this->generateAssetCode($data['category_id']);

            // 2. Simpan Aset Utama
            $asset = Asset::create([
                'asset_code'    => $assetCode,
                'name'          => $data['name'],
                'category_id'   => $data['category_id'],
                'location_id'   => $data['location_id'],
                'purchase_date' => $data['purchase_date'],
                'price'         => $data['price'] ?? 0,
                'status'        => $data['status'] ?? 'active',
                'condition'     => $data['condition'] ?? 'good',
                'notes'         => $data['notes'] ?? null,
            ]);

            // 3. Catat Audit Trail
            $this->recordTracking(
                asset: $asset,
                action: 'created',
                notes: 'Registrasi aset baru ke dalam sistem.',
                previousState: null,
                newState: $asset->toArray()
            );

            return $asset;
        });
    }

    /**
     * Memperbarui data aset dan mencatat perubahannya.
     * * @throws Throwable
     */
    public function updateAsset(Asset $asset, array $data): Asset
    {
        return DB::transaction(function () use ($asset, $data) {
            // Simpan state lama sebelum diubah
            $previousState = $asset->toArray();

            // Lakukan update
            $asset->update($data);

            // Tentukan jenis action berdasarkan perubahan (misal: pindah lokasi vs update biasa)
            $action = 'updated';
            $notes = 'Pembaruan data aset.';

            if (isset($data['location_id']) && $previousState['location_id'] !== $data['location_id']) {
                $action = 'moved';
                $notes = 'Aset dipindahkan ke lokasi baru.';
            }

            // Catat Audit Trail dengan state sebelum dan sesudah
            $this->recordTracking(
                asset: $asset,
                action: $action,
                notes: $notes,
                previousState: $previousState,
                newState: $asset->fresh()->toArray()
            );

            return $asset;
        });
    }

    /**
     * Method internal untuk mencatat riwayat ke tabel asset_trackings.
     */
    protected function recordTracking(Asset $asset, string $action, string $notes, ?array $previousState = null, ?array $newState = null): AssetTracking
    {
        return AssetTracking::create([
            'asset_id'       => $asset->id,
            'user_id'        => Auth::id(), // Akan null jika dijalankan via seeder/console tanpa auth
            'action'         => $action,
            'notes'          => $notes,
            'previous_state' => $previousState,
            'new_state'      => $newState,
        ]);
    }

    /**
     * Generator sederhana untuk kode unik aset UNMARIS.
     */
    protected function generateAssetCode(int $categoryId): string
    {
        $year = date('Y');
        $randomStr = strtoupper(substr(uniqid(), -5));

        return sprintf("UNM-%s-%s-%s", $year, $categoryId, $randomStr);
    }
}
