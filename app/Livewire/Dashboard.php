<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Asset;
use App\Models\AssetTracking;

#[Title('Dashboard - UNMARIS')]
class Dashboard extends Component
{
    public function render()
    {
        // Agregasi dasar
        $totalAssets = Asset::count();
        $totalValue = Asset::sum('price');
        $activeAssets = Asset::where('status', 'active')->count();
        $maintenanceAssets = Asset::where('status', 'maintenance')->count();

        // Agregasi kondisi fisik
        $goodCondition = Asset::where('condition', 'good')->count();
        $brokenCondition = Asset::whereIn('condition', ['poor', 'broken'])->count();
        
        // Persentase kesehatan aset (mencegah pembagian dengan nol)
        $healthPercentage = $totalAssets > 0 ? round(($goodCondition / $totalAssets) * 100) : 0;

        // Riwayat aktivitas terbaru (5 data terakhir)
        $recentActivities = AssetTracking::with(['asset', 'user'])
                            ->latest()
                            ->limit(5)
                            ->get();

        return view('livewire.dashboard', compact(
            'totalAssets', 'totalValue', 'activeAssets', 'maintenanceAssets', 
            'goodCondition', 'brokenCondition', 'healthPercentage', 'recentActivities'
        ))->layoutData(['header' => 'Ringkasan Sistem Aset']);
    }
}