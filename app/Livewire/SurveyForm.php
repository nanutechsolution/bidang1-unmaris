<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Exception;

#[Title('Survei Kepuasan - UNMARIS')]
#[Layout('components.layouts.auth')]
class SurveyForm extends Component
{
    public Survey $survey;
    
    // Properti Read-Only dari SIAKAD
    public string $name = '';
    public string $role = '';
    public string $nim_nidn = ''; 

    // Array Dinamis untuk menampung jawaban
    public array $answers = [];
    
    public bool $isSubmitted = false;
    public bool $isAuthenticated = false;

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
        
        // 1. Validasi Status Survei
        if (!$this->survey->is_active) {
            abort(404, 'Mohon maaf, survei ini sudah ditutup atau dinonaktifkan.');
        }

        // Validasi waktu (jika start_at dan end_at diimplementasikan di tabel surveys)
        // if (now()->lt($this->survey->start_at) || now()->gt($this->survey->end_at)) {
        //     abort(404, 'Survei ini berada di luar periode pengisian.');
        // }

        // 2. Jalankan proses autentikasi
        $this->handleAuthentication();

        // 3. Cek apakah user sudah pernah mengisi survei ini (Early Check)
        $hasSubmitted = SurveyResponse::where('survey_id', $this->survey->id)
            ->where('identifier', $this->nim_nidn)
            ->exists();

        if ($hasSubmitted) {
            $this->isSubmitted = true;
            return;
        }

        // 4. Inisialisasi slot jawaban kosong
        foreach ($this->survey->questions as $question) {
            $this->answers[$question->id] = '';
        }
    }

    /**
     * Menangani alur autentikasi, caching session, dan pembersihan URL
     */
    private function handleAuthentication(): void
    {
        $token = request()->query('token');

        // Jika ada token di URL, validasi ke API SIAKAD lalu simpan ke session
        if ($token) {
            $this->fetchUserFromApi($token);
            
            // Redirect untuk membersihkan token dari URL demi keamanan (Mencegah token tersebar jika URL di-copy)
            redirect()->to('/survei/' . $this->survey->id);
            return;
        }

        // Jika tidak ada token di URL, muat dari Session yang sudah di-cache
        $this->loadUserFromSession();
    }

    /**
     * Mengambil data dari API dan menyimpannya di Session
     */
    private function fetchUserFromApi(string $token): void
    {
        try {
            // Gunakan config() bukan env() langsung untuk standardisasi production
            $apiUrl = config('services.siakad.url', 'http://127.0.0.1:8001/api') . '/user/me';
            
            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(10) // Proteksi agar tidak hanging
                ->get($apiUrl);

            if ($response->status() === 401) {
                session()->forget('siakad_user');
                abort(403, 'Akses Ditolak: Sesi Anda telah berakhir atau token tidak valid. Silakan login kembali melalui SIAKAD.');
            }

            if (!$response->successful()) {
                Log::error("SIAKAD API Error: " . $response->body());
                abort(500, 'Gagal terhubung ke server SIAKAD. Silakan coba beberapa saat lagi.');
            }

            $userData = $response->json('data') ?? $response->json();
            $role = strtolower($userData['role'] ?? '');
            $status = strtolower($userData['status'] ?? 'aktif');

            // Batasi akses role
            if (!in_array($role, ['mahasiswa', 'dosen'])) {
                abort(403, 'Akses Ditolak: Survei ini hanya diperuntukkan bagi Mahasiswa dan Dosen Universitas Stella Maris.');
            }

            // Pastikan user aktif
            if ($status !== 'aktif') {
                abort(403, 'Akses Ditolak: Status akun Anda saat ini sedang tidak aktif di sistem akademik.');
            }

            // Simpan hasil API ke session untuk efisiensi
            session()->put('siakad_user', [
                'name' => $userData['name'] ?? 'Pengguna SIAKAD',
                'role' => $role,
                'identifier' => $userData['identifier'] ?? ($userData['nim'] ?? ($userData['nidn'] ?? 'Unknown')),
            ]);

            $this->populateUserData();

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("SIAKAD API Timeout: " . $e->getMessage());
            abort(500, 'Koneksi ke server SIAKAD terputus (Timeout). Harap pastikan layanan SIAKAD sedang berjalan.');
        }
    }

    /**
     * Memuat data pengguna dari Session tanpa harus call API lagi
     */
    private function loadUserFromSession(): void
    {
        if (!session()->has('siakad_user')) {
            abort(403, 'Akses Ditolak: Sesi tidak ditemukan. Silakan akses survei ini melalui portal SIAKAD (Sistem Informasi Akademik).');
        }

        $this->populateUserData();
    }

    private function populateUserData(): void
    {
        $userData = session()->get('siakad_user');
        
        $this->isAuthenticated = true;
        $this->name = $userData['name'];
        $this->role = $userData['role'];
        $this->nim_nidn = $userData['identifier'];
    }

    public function setRating($questionId, $value)
    {
        $this->answers[$questionId] = $value;
    }

    public function submit()
    {
        if (!$this->isAuthenticated || $this->isSubmitted) {
            return;
        }

        // 1. Validasi Input Dinamis
        $rules = [];
        $messages = [];

        foreach ($this->survey->questions as $question) {
            if ($question->is_required) {
                $rules['answers.' . $question->id] = 'required';
                $messages['answers.' . $question->id . '.required'] = 'Pertanyaan ini wajib dijawab.';
            }
        }

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // 2. Simpan Data Responden
            $response = SurveyResponse::create([
                'survey_id' => $this->survey->id,
                'name' => $this->name,
                'role' => $this->role,
                'identifier' => $this->nim_nidn,
            ]);

            // 3. Simpan Jawaban
            $answersToInsert = [];
            foreach ($this->survey->questions as $question) {
                if (isset($this->answers[$question->id]) && $this->answers[$question->id] !== '') {
                    $answersToInsert[] = [
                        'id' => \Illuminate\Support\Str::uuid()->toString(),
                        'survey_response_id' => $response->id,
                        'survey_question_id' => $question->id,
                        'answer_text' => $question->type === 'text' ? $this->answers[$question->id] : null,
                        'answer_rating' => $question->type === 'rating' ? $this->answers[$question->id] : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            
            // Insert array answers sekaligus untuk performa (Batch Insert)
            if (count($answersToInsert) > 0) {
                DB::table('survey_answers')->insert($answersToInsert);
            }

            DB::commit();

            // 4. Audit Trail (Pencatatan Log untuk Security dan Forensik)
            Log::info("Survey Submitted", [
                'survey_id' => $this->survey->id,
                'identifier' => $this->nim_nidn,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $this->isSubmitted = true;

        } catch (QueryException $e) {
            DB::rollBack();
            
            // Penanganan Race Condition (Double Click Submit / Bypass UI)
            // Asumsi: Di Database terdapat Unique Constraint pada kombinasi (survey_id, identifier)
            // Cek Kode Error 23000 (Integrity constraint violation)
            if ($e->getCode() == 23000) {
                $this->isSubmitted = true; // Langsung anggap sukses agar UI berubah, meski sebenarnya duplikat dari race condition
                Log::warning("Double submit detected via DB constraint", ['identifier' => $this->nim_nidn, 'survey_id' => $this->survey->id]);
            } else {
                Log::error("Survey DB Error: " . $e->getMessage());
                $this->addError('submit', 'Terjadi kesalahan sistem saat memproses data. Silakan coba lagi.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Survey General Error: " . $e->getMessage());
            $this->addError('submit', 'Gagal menyimpan jawaban: Kesalahan server internal.');
        }
    }

    public function render()
    {
        return view('livewire.survey-form');
    }
}