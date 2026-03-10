<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Document;

class StatsOverview extends BaseWidget
{
    // Mengatur urutan agar tampil paling atas di dashboard
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();
        
        // Mulai query dokumen
        $query = Document::query();

        // Jika user adalah prodi, batasi hitungan HANYA untuk dokumen prodinya
        if (isset($user->role) && $user->role === 'prodi') {
            $query->where('unit_id', $user->unit_id);
        }

        // Kloning query agar bisa dipakai untuk menghitung beberapa kondisi berbeda
        $totalDocs = (clone $query)->count();
        $approvedDocs = (clone $query)->where('status', 'approved')->count();
        
        // Menggabungkan status draft dan revised sebagai dokumen yang "Belum Selesai"
        $pendingDocs = (clone $query)->whereIn('status', ['draft', 'revised'])->count();

        return [
            Stat::make('Total Dokumen', $totalDocs)
                ->description('Semua dokumen yang diunggah')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('primary'),
                
            Stat::make('Dokumen Disetujui', $approvedDocs)
                ->description('Telah divalidasi pimpinan')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
                
            Stat::make('Perlu Tindakan', $pendingDocs)
                ->description('Status Draft / Revisi')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
        ];
    }
}