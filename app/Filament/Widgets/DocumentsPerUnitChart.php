<?php

namespace App\Filament\Widgets;

use App\Models\Unit;
use Filament\Widgets\ChartWidget;

class DocumentsPerUnitChart extends ChartWidget
{
    protected ?string $heading = 'Documents Per Unit Chart';

    // Tampil di bawah Widget Statistik
    protected static ?int $sort = 2;

    /**
     * LOGIKA HAK AKSES
     * Grafik ini HANYA boleh dilihat oleh pimpinan/rektorat dan super_admin.
     * Dosen prodi tidak akan melihat grafik ini di dashboard mereka.
     */
    public static function canView(): bool
    {
        $user = auth()->user();
        return isset($user->role) && in_array($user->role, ['super_admin', 'rektorat']);
    }

    protected function getData(): array
    {
        // Mengambil semua unit yang bertipe 'prodi' beserta jumlah dokumennya
        $units = Unit::where('type', 'prodi')->withCount('documents')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Dokumen',
                    'data' => $units->pluck('documents_count')->toArray(),
                    // Memberikan warna pada grafik batang
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            // Label sumbu X diisi dengan nama-nama prodi
            'labels' => $units->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Jenis grafik: Bar Chart (Batang)
    }
}
