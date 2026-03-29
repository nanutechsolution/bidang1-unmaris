<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\AssetCategory;
use App\Models\Location;
use App\Services\AssetService;
use Exception;

#[Title('Tambah Aset Baru - UNMARIS')]
class AssetCreate extends Component
{
    // Validasi super rapi menggunakan Attribute Livewire 3
    #[Validate('required|min:3|max:150')]
    public string $name = '';

    #[Validate('required|exists:asset_categories,id')]
    public ?string $category_id = "";

    #[Validate('required|exists:locations,id')]
    public ?string $location_id = "";

    // Memastikan tanggal beli tidak lebih dari hari ini
    #[Validate('required|date|before_or_equal:today')]
    public string $purchase_date = '';

    #[Validate('nullable|numeric|min:0')]
    public float|int $price = 0;

    #[Validate('required|in:active,maintenance,disposed,lost')]
    public string $status = 'active';

    #[Validate('required|in:good,fair,poor,broken')]
    public string $condition = 'good';

    #[Validate('nullable|string|max:1000')]
    public ?string $notes = null;

    /**
     * Dependency Injection AssetService langsung di parameter method
     */
    public function save(AssetService $assetService)
    {
        // 1. Jalankan semua #[Validate]
        $this->validate();

        try {
            // 2. Lempar data bersih ke Service Layer
            $assetService->createAsset([
                'name'          => $this->name,
                'category_id'   => $this->category_id,
                'location_id'   => $this->location_id,
                'purchase_date' => $this->purchase_date,
                'price'         => $this->price,
                'status'        => $this->status,
                'condition'     => $this->condition,
                'notes'         => $this->notes,
            ]);

            // 3. Beri notifikasi sukses
            session()->flash('success', 'Aset berhasil didaftarkan dan riwayat awal telah dicatat.');

            // 4. Redirect kembali ke halaman Index menggunakan mode SPA (navigate: true)
            return $this->redirectRoute('assets.index', navigate: true);
        } catch (Exception $e) {
            // Tangkap error jika database gagal/rollback
            $this->dispatch('notify', type: 'error', message: 'Terjadi kesalahan saat menyimpan data aset.');
        }
    }

    public function render()
    {
        return view('livewire.asset-create', [
            // Kirim master data ke dropdown
            'categories' => AssetCategory::orderBy('name')->get(),
            'locations'  => Location::orderBy('name')->get(),
        ])->layoutData(['header' => 'Tambah Data Aset Baru']);
    }
}
