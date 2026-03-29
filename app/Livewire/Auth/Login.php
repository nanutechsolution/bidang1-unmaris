<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

#[Title('Login - SI Aset UNMARIS')]
#[Layout('components.layouts.auth')] 
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function authenticate()
    {
        $this->validate(
            ['email' => 'required|email', 'password' => 'required'],
            ['email.required' => 'Email wajib diisi.', 'email.email' => 'Format email tidak valid.', 'password.required' => 'Kata sandi wajib diisi.']
        );

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Cek apakah user aktif
            if (!Auth::user()->is_active) {
                Auth::logout();
                $this->dispatch('notify', type: 'error', message: 'Akun Anda dinonaktifkan. Hubungi Administrator.');
                return;
            }

            session()->regenerate();
            return $this->redirectRoute('dashboard', navigate: true);
        }

        $this->dispatch('notify', type: 'error', message: 'Kredensial tidak cocok dengan data kami.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
