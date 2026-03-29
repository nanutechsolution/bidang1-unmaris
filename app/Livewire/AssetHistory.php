<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Asset;
use App\Services\AssetService;
use Exception;

#[Title('Riwayat Aset - UNMARIS')]
class AssetHistory extends Component
{
    public Asset $asset;

    // State untuk form tambah catatan manual
    public string $manual_note = '';

    /**
     * Mount data aset saat halaman pertama kali dimuat
     */
    public function mount(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Kustomisasi Pesan Validasi ke Bahasa Indonesia
     */
    protected function messages()
    {
        return [
            'manual_note.required' => 'Catatan riwayat tidak boleh kosong.',
            'manual_note.min'      => 'Catatan riwayat minimal harus 5 karakter.',
            'manual_note.max'      => 'Catatan riwayat terlalu panjang (maksimal 500 karakter).',
        ];
    }

    /**
     * Menyimpan catatan manual ke timeline
     */
    public function addNote(AssetService $assetService)
    {
        $this->validate([
            'manual_note' => 'required|min:5|max:500',
        ]);

        try {
            // Gunakan reflection/method dari Service yang sudah kita buat sebelumnya
            // Karena method recordTracking bersifat protected di Service, 
            // kita bisa membuat method public 'addManualLog' di AssetService, atau langsung via model di sini untuk kasus sederhana:
            
            $this->asset->trackings()->create([
                'user_id' => auth()->id() ?? 1, // Fallback ke user 1 jika tidak ada auth di local
                'action'  => 'note_added',
                'notes'   => $this->manual_note,
            ]);

            // Reset form
            $this->reset('manual_note');

            // Panggil Toast Notification yang sudah kita buat di Step 12
            $this->dispatch('notify', type: 'success', message: 'Catatan berhasil ditambahkan ke riwayat aset.');

        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Gagal menyimpan catatan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.asset-history', [
            // Eager load relasi user agar tidak N+1 saat menampilkan nama pembuat log
            'trackings' => $this->asset->trackings()->with('user')->latest()->get()
        ])->layoutData(['header' => 'Detail & Riwayat Aset']);
    }
}