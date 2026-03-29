<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Exception;

#[Title('Builder Survei - UNMARIS')]
class SurveyEditor extends Component
{
    public ?Survey $survey = null;
    
    // Properti Utama Survei
    public string $title = '';
    public string $description = '';
    public bool $is_active = true;

    // Array Dinamis untuk menampung banyak pertanyaan
    public array $questions = [];

    public function mount(?Survey $survey = null)
    {
        if ($survey && $survey->exists) {
            $this->survey = $survey;
            $this->title = $survey->title;
            $this->description = $survey->description ?? '';
            $this->is_active = $survey->is_active;

            // Muat pertanyaan yang sudah ada di database
            foreach ($survey->questions as $q) {
                $this->questions[] = [
                    'id' => $q->id,
                    'question_text' => $q->question_text,
                    'type' => $q->type,
                    'is_required' => (bool) $q->is_required,
                ];
            }
        } else {
            // Jika buat baru, sediakan 1 blok pertanyaan kosong secara default
            $this->addQuestion();
        }
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => null,
            'question_text' => '',
            'type' => 'rating', // Default tipe rating (bintang)
            'is_required' => true,
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        // Re-index array agar urutannya tidak berantakan setelah dihapus
        $this->questions = array_values($this->questions); 
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|min:3',
            'questions.*.type' => 'required|in:rating,text',
        ], [
            'title.required' => 'Judul survei wajib diisi.',
            'questions.min' => 'Survei minimal harus memiliki 1 pertanyaan.',
            'questions.*.question_text.required' => 'Teks pertanyaan tidak boleh kosong.',
        ]);

        // Gunakan Transaction agar jika salah satu gagal, semuanya di-rollback
        DB::beginTransaction();
        try {
            // 1. Simpan Survei
            $survey = Survey::updateOrCreate(
                ['id' => $this->survey?->id],
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'is_active' => $this->is_active,
                ]
            );

            // 2. Sinkronisasi Pertanyaan
            // Ambil ID pertanyaan lama yang masih dipertahankan di form
            $keptQuestionIds = collect($this->questions)->pluck('id')->filter()->toArray();

            // Hapus pertanyaan lama di DB yang dibuang oleh Admin di form
            $survey->questions()->whereNotIn('id', $keptQuestionIds)->delete();

            // 3. Simpan atau perbarui pertanyaan yang ada di array
            foreach ($this->questions as $index => $q) {
                $survey->questions()->updateOrCreate(
                    ['id' => $q['id']],
                    [
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'is_required' => $q['is_required'],
                        'order' => $index, // Simpan urutannya
                    ]
                );
            }

            DB::commit();
            
            // Redirect kembali ke halaman manajemen survei
            session()->flash('success', 'Survei berhasil disimpan!');
            return $this->redirectRoute('survey.results', navigate: true);

        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.survey-editor')->layoutData(['header' => 'Form Builder Survei']);
    }
}