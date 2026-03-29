<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use App\Models\Asset;
use Illuminate\View\View;

#[Title('Master Data Aset - UNMARIS')]
class AssetIndex extends Component
{
    use WithPagination;

    // Menyimpan state search di URL agar bisa di-share/bookmark
    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $status = '';

    /**
     * Reset pagination kembali ke halaman 1 setiap kali user mengetik pencarian
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        // 1. Eager Loading relasi Category & Location (Proteksi N+1 Query)
        $query = Asset::with(['category', 'location'])
            ->when($this->search, function ($q) {
                // Pencarian berdasarkan Nama Aset atau Kode Aset
                $q->where(function ($subQ) {
                    $subQ->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('asset_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($q) {
                // Filter berdasarkan status
                $q->where('status', $this->status);
            })
            ->latest('id'); // Urutkan dari yang terbaru

        return view('livewire.asset-index', [
            'assets' => $query->paginate(10) // Server-side pagination (10 data per halaman)
        ])->layoutData(['header' => 'Master Data Aset']);
    }
}