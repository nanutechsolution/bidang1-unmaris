<?php

namespace App\Filament\Pages\Auth;

use App\Services\SiakadService;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Schemas\Components\Component;

class Login extends BaseLogin
{

    /**
     * Mengambil alih proses autentikasi bawaan Filament untuk menggunakan SIAKAD
     */
    public function authenticate(): ?LoginResponse
    {
        // Ambil data dari form login
        $data = $this->form->getState();

        // Panggil Service SIAKAD yang sudah kita sesuaikan dengan API
        $siakad = app(SiakadService::class);

        // Proses 1: Cek kredensial ke API SIAKAD
        if ($siakad->authenticate($data['email'], $data['password'])) {

            // Proses 2: Jika API sukses, cari user di database lokal (yang sudah di-sync oleh service)
            // Pencarian berdasarkan identifier (NIDN/Username) yang kita simpan di email/name
            $user = User::where('name', 'LIKE', '%' . $data['email'] . '%')
                ->orWhere('email', 'LIKE', '%' . $data['email'] . '%')
                ->first();

            if ($user) {
                Auth::login($user, $data['remember'] ?? false);
                session()->regenerate();

                return app(LoginResponse::class);
            }
        }

        // Proses 3: Jika gagal, tampilkan notifikasi error di UI Filament
        Notification::make()
            ->title('Gagal Autentikasi SIAKAD')
            ->body('NIDN atau Password Anda tidak sesuai dengan data SIAKAD.')
            ->danger()
            ->send();

        return null;
    }

    /**
     * Ubah label input agar lebih familiar bagi Dosen UNMARIS
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('NIDN / Username SIAKAD')
            ->placeholder('Masukkan NIDN Anda')
            ->required()
            ->autocomplete()
            ->autofocus();
    }
}
