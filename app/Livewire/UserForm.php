<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Exception;

#[Title('Form Pengguna - UNMARIS')]
class UserForm extends Component
{
    public ?User $user = null;
    public bool $isEdit = false;

    public string $name = '';
    public string $email = '';
    public string $role = 'operator';
    public bool $is_active = true;
    public string $password = ''; // Kosongkan saat edit jika tidak ingin diganti

    public function mount(?User $user = null)
    {
        // Jika parameter user terisi (ada data dari DB berdasarkan UUID)
        if ($user && $user->exists) {
            $this->user = $user;
            $this->isEdit = true;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->is_active = $user->is_active;
        }
    }

    public function save(UserService $userService)
    {
        // Validasi dinamis karena Email harus unik kecuali untuk user yang sedang di-edit
        $rules = [
            'name'  => 'required|min:3|max:100',
            'role'  => 'required|in:admin,operator,viewer',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($this->user?->id),
            ],
        ];

        // Jika tambah baru, password wajib. Jika edit, opsional.
        if (!$this->isEdit) {
            $rules['password'] = 'required|min:6';
        } elseif (!empty($this->password)) {
            $rules['password'] = 'min:6';
        }

        $this->validate($rules, [
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal 6 karakter.'
        ]);

        try {
            $userService->saveUser($this->user, [
                'name'      => $this->name,
                'email'     => $this->email,
                'role'      => $this->role,
                'is_active' => $this->is_active,
                'password'  => $this->password,
            ]);

            session()->flash('success', $this->isEdit ? 'Data pengguna diperbarui.' : 'Pengguna baru berhasil ditambahkan.');
            return $this->redirectRoute('users.index', navigate: true);

        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user-form')
            ->layoutData(['header' => $this->isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru']);
    }
}