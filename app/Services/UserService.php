<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    public function saveUser(?User $user, array $data): User
    {
        // Cegah Admin menonaktifkan atau mengubah role dirinya sendiri secara tidak sengaja
        if ($user && $user->id === auth()->id()) {
            if ($data['role'] !== 'admin' || !$data['is_active']) {
                throw new Exception("Anda tidak dapat mengubah role atau menonaktifkan akun Anda sendiri saat sedang login.");
            }
        }

        $userData = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'is_active' => $data['is_active'] ?? true,
        ];

        // Jika password diisi (saat create atau saat admin mereset password user)
        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        if ($user && $user->exists) {
            $user->update($userData);
            return $user;
        }

        return User::create($userData);
    }

    public function toggleActiveStatus(User $user): void
    {
        if ($user->id === auth()->id()) {
            throw new Exception("Anda tidak dapat menonaktifkan akun Anda sendiri.");
        }
        
        $user->update(['is_active' => !$user->is_active]);
    }
}