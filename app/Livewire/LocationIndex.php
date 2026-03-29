<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Location;
use Exception;

#[Title('Master Lokasi - UNMARIS')]
class LocationIndex extends Component
{
    use WithPagination;

    // State Form
    public $locationId = null;
    public string $building = '';
    public string $room_number = '';
    public string $name = '';
    
    // State UI
    public string $search = '';
    public bool $isEdit = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset(['locationId', 'building', 'room_number', 'name', 'isEdit']);
        $this->resetValidation();
    }

    public function edit(Location $location)
    {
        $this->locationId = $location->id;
        $this->building = $location->building;
        $this->room_number = $location->room_number ?? '';
        $this->name = $location->name;
        $this->isEdit = true;
    }

    public function save()
    {
        $this->validate([
            'building' => 'required|string|max:100',
            'room_number' => 'nullable|string|max:50',
            'name' => 'required|string|max:100',
        ]);

        try {
            Location::updateOrCreate(
                ['id' => $this->locationId],
                [
                    'building' => $this->building,
                    'room_number' => $this->room_number,
                    'name' => $this->name,
                ]
            );

            $this->dispatch('notify', type: 'success', message: $this->isEdit ? 'Lokasi diperbarui.' : 'Lokasi baru ditambahkan.');
            $this->resetFields();
            
        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function delete(Location $location)
    {
        if ($location->assets()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: 'Gagal! Lokasi ini sedang ditempati oleh aset.');
            return;
        }

        $location->delete();
        $this->dispatch('notify', type: 'success', message: 'Lokasi berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.location-index', [
            'locations' => Location::where('name', 'like', "%{$this->search}%")
                ->orWhere('building', 'like', "%{$this->search}%")
                ->orWhere('room_number', 'like', "%{$this->search}%")
                ->orderBy('building')
                ->orderBy('name')
                ->paginate(10)
        ])->layoutData(['header' => 'Master Lokasi & Ruangan']);
    }
}