<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate untuk mengecek apakah user aktif
        Gate::define('active', fn(User $user) => $user->is_active);

        // Gate spesifik role
        Gate::define('manage-users', fn(User $user) => $user->isAdmin());
        Gate::define('edit-assets', fn(User $user) => $user->isOperator());
    }
}
