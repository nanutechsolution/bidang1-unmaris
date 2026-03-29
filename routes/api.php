<?php

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/surveys/active', function (Request $request) {
    $identifier = $request->query('identifier');

    // Mulai query: Ambil survei yang aktif dan urutkan dari yang terbaru
    $query = Survey::where('is_active', true)->latest();

    // JIKA SIAKAD mengirimkan NIM/NIDN, filter surveinya!
    if ($identifier) {
        // "Ambil survei yang TIDAK MEMILIKI response dari identifier ini"
        $query->whereDoesntHave('responses', function ($q) use ($identifier) {
            $q->where('identifier', $identifier);
        });
    }

    $surveys = $query->get();

    return response()->json([
        'data' => $surveys
    ]);
});
