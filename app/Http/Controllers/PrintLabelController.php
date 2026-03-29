<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class PrintLabelController extends Controller
{
    /**
     * Cetak label untuk satu aset spesifik
     */
    public function printSingle(Asset $asset)
    {
        // URL yang akan dibuka saat QR di-scan (mengarah ke halaman Riwayat Aset)
        $qrUrl = route('assets.history', $asset->id);

        return view('print.asset-label', [
            'assets' => collect([$asset]), // Jadikan collection agar view bisa dipakai ulang untuk mass print
            'qrUrlBuilder' => fn($id) => route('assets.history', $id)
        ]);
    }

    /**
     * Cetak label massal berdasarkan filter pencarian (Opsional, sangat berguna di enterprise)
     */
    public function printMass(Request $request)
    {
        $query = Asset::query();
        
        if ($request->has('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        
        // Batasi maksimal 50 label sekali cetak agar browser tidak crash
        $assets = $query->limit(50)->get();

        return view('print.asset-label', [
            'assets' => $assets,
            'qrUrlBuilder' => fn($id) => route('assets.history', $id)
        ]);
    }
}