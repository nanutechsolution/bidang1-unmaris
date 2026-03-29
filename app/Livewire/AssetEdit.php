<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use App\Services\AssetService;
use Exception;

#[Title('Edit Data Aset - UNMARIS')]
class AssetEdit extends Component
{
    public Asset $asset;

    #[Validate('required|min:3|max:150')]
    public string $name = '';

    #[Validate('required|exists:asset_categories,id')]
    public ?string $category_id = null;

    #[Validate('required|exists:locations,id')]
    public ?string $location_id = null;

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
     * Mount data aset yang sudah ada ke dalam form
     */
    public function mount(Asset $asset)
    {
        $this->asset = $asset;
        $this->name = $asset->name;
        $this->category_id = $asset->category_id;
        $this->location_id = $asset->location_id;
        $this->purchase_date = $asset->purchase_date->format('Y-m-d');
        $this->price = (float) $asset->price;
        $this->status = $asset->status;
        $this->condition = $asset->condition;
        $this->notes = $asset->notes;
    }

    /**
     * Inject AssetService yang sudah kita buat sebelumnya
     */
    public function update(AssetService $assetService)
    {
        $this->validate();

        try {
            // Service layer akan otomatis mendeteksi perubahan dan mencatatnya di Audit Trail!
            $assetService->updateAsset($this->asset, [
                'name'          => $this->name,
                'category_id'   => $this->category_id,
                'location_id'   => $this->location_id,
                'purchase_date' => $this->purchase_date,
                'price'         => $this->price,
                'status'        => $this->status,
                'condition'     => $this->condition,
                'notes'         => $this->notes,
            ]);

            session()->flash('success', 'Data aset berhasil diperbarui.');
            return $this->redirectRoute('assets.index', navigate: true);
        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.asset-edit', [
            'categories' => AssetCategory::orderBy('name')->get(),
            'locations'  => Location::orderBy('name')->get(),
        ])->layoutData(['header' => 'Edit Data Aset: ' . $this->asset->asset_code]);
    }
}
