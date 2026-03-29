<?php

use App\Livewire\Auth\Login;
use App\Livewire\CategoryIndex;
use App\Livewire\LocationIndex;
use App\Livewire\UserForm;
use App\Livewire\UserIndex;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute Publik (Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Rute Terproteksi
Route::middleware('auth')->group(function () {

    // Rute Logout (Bisa menggunakan fungsi anonim sederhana di web.php)
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // --- Rute Dashboard & Master Aset (Dari step sebelumnya) ---
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Rute Aset
    Route::get('/assets', \App\Livewire\AssetIndex::class)->name('assets.index');
    Route::get('/assets/{asset}/history', \App\Livewire\AssetHistory::class)->name('assets.history');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/locations', LocationIndex::class)->name('locations.index');

    // Rute khusus Operator/Admin
    Route::middleware('can:edit-assets')->group(function () {
        Route::get('/assets/create', \App\Livewire\AssetCreate::class)->name('assets.create');
        Route::get('/assets/{asset}/edit', \App\Livewire\AssetEdit::class)->name('assets.edit');
    });

    // Rute Print (Dikeluarkan dari grup can agar pimpinan/viewer bisa print label)
    Route::get('/assets/{asset}/print', [\App\Http\Controllers\PrintLabelController::class, 'printSingle'])->name('assets.print');
    Route::get('/survei/builder/create', \App\Livewire\SurveyEditor::class)->name('survey.create');
    Route::get('/survei/builder/{survey}/edit', \App\Livewire\SurveyEditor::class)->name('survey.edit');
    Route::get('/survei/hasil', \App\Livewire\SurveyIndex::class)->name('survey.results');
    Route::middleware('can:manage-users')->group(function () {
        Route::get('/users', UserIndex::class)->name('users.index');
        Route::get('/users/create', UserForm::class)->name('users.create');
        Route::get('/users/{user}/edit', UserForm::class)->name('users.edit');
    });
});


Route::get('/survei/{survey}', \App\Livewire\SurveyForm::class)->name('survey.show');
