<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Survey; // Menggunakan model Survey yang baru

#[Title('Manajemen Survei Dinamis - UNMARIS')]
class SurveyIndex extends Component
{
    use WithPagination;

    public string $search = '';

    // Reset pagination ketika admin melakukan pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Fungsi untuk mengaktifkan/menonaktifkan link survei
    public function toggleStatus($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->update(['is_active' => !$survey->is_active]);
        
        $this->dispatch('notify', type: 'success', message: 'Status survei berhasil diubah.');
    }

    // Fungsi untuk menghapus survei beserta pertanyaannya
    public function delete($id)
    {
        Survey::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Survei berhasil dihapus.');
    }

    public function render()
    {
        // Ambil daftar survei beserta jumlah responden yang sudah mengisi
        $surveys = Survey::withCount('responses')
            ->where('title', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(10);

        return view('livewire.survey-index', [
            'surveys' => $surveys,
        ])->layoutData(['header' => 'Manajemen Survei Dinamis']);
    }
}