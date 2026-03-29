<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Services\UserService;
use Exception;

#[Title('Manajemen Pengguna - UNMARIS')]
class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus(User $user, UserService $userService)
    {
        try {
            $userService->toggleActiveStatus($user);
            $this->dispatch('notify', type: 'success', message: 'Status pengguna berhasil diperbarui.');
        } catch (Exception $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.user-index', compact('users'))
            ->layoutData(['header' => 'Manajemen Pengguna & Hak Akses']);
    }
}