<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\AssetCategory;
use Illuminate\Validation\Rule;
use Exception;

#[Title('Master Kategori - UNMARIS')]
class CategoryIndex extends Component
{
    use WithPagination;

    // State Form
    public $categoryId = null;
    public string $code = '';
    public string $name = '';
    public ?string $description = null;
    
    // State UI
    public string $search = '';
    public bool $isEdit = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset(['categoryId', 'code', 'name', 'description', 'isEdit']);
        $this->resetValidation();
    }

    public function edit(AssetCategory $category)
    {
        $this->categoryId = $category->id;
        $this->code = $category->code;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isEdit = true;
    }

    public function save()
    {
        $this->validate([
            'code' => [
                'required', 'string', 'max:20', 
                Rule::unique('asset_categories', 'code')->ignore($this->categoryId)
            ],
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ], [
            'code.unique' => 'Kode kategori ini sudah digunakan.',
        ]);

        try {
            AssetCategory::updateOrCreate(
                ['id' => $this->categoryId],
                [
                    'code' => strtoupper($this->code),
                    'name' => $this->name,
                    'description' => $this->description,
                ]
            );

            $this->dispatch('notify', type: 'success', message: $this->isEdit ? 'Kategori berhasil diperbarui.' : 'Kategori baru ditambahkan.');
            $this->resetFields();
            
        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function delete(AssetCategory $category)
    {
        // Proteksi: Jangan hapus jika ada aset yang terhubung
        if ($category->assets()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: 'Gagal! Kategori ini sedang digunakan oleh data aset.');
            return;
        }

        $category->delete();
        $this->dispatch('notify', type: 'success', message: 'Kategori berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.category-index', [
            'categories' => AssetCategory::where('name', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%")
                ->orderBy('name')
                ->paginate(10)
        ])->layoutData(['header' => 'Master Kategori Aset']);
    }
}