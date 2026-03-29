<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Aset UNMARIS</title>
    @vite('resources/css/app.css')
    
    <style>
        /* Pengaturan khusus saat mode print berjalan */
        @media print {
            body {
                background-color: white !important;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            /* Menghilangkan margin bawaan browser saat print */
            @page {
                margin: 0.5cm;
            }
            /* Mencegah label terpotong di tengah halaman */
            .label-card {
                page-break-inside: avoid;
            }
        }
        
        /* Grid untuk kertas A4 (biasanya 3 kolom label) */
        .label-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen pb-10">

    <!-- Action Bar (Akan hilang saat di-print) -->
    <div class="no-print sticky top-0 bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex justify-between items-center z-50">
        <div>
            <h1 class="text-lg font-bold text-gray-800">Preview Cetak Label ({{ $assets->count() }} Aset)</h1>
            <p class="text-sm text-gray-500">Pastikan ukuran kertas di setting printer sudah sesuai.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.close()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors">
                Tutup
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-unmaris-600 hover:bg-unmaris-700 text-white font-medium rounded-lg text-sm shadow-md transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Sekarang
            </button>
        </div>
    </div>

    <!-- Area Kertas -->
    <div class="max-w-5xl mx-auto mt-6 bg-white shadow-lg min-h-[29.7cm]">
        <div class="label-grid">
            @foreach($assets as $asset)
                <!-- Label Card (1 Stiker) -->
                <div class="label-card border-2 border-dashed border-gray-300 rounded-xl p-3 flex gap-3 relative overflow-hidden">
                    
                    <!-- Aksen Warna Kampus -->
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-unmaris-600"></div>

                    <!-- QR Code (SVG Format, tajam tanpa pecah) -->
                    <div class="flex-shrink-0 mt-1">
                        {!! 
                            QrCode::size(70)
                                ->style('round') /* Style modern melingkar */
                                ->eye('circle') 
                                ->generate($qrUrlBuilder($asset->id)) 
                        !!}
                    </div>

                    <!-- Detail Teks -->
                    <div class="flex flex-col justify-center flex-1 min-w-0">
                        <div class="text-[10px] font-bold text-unmaris-700 tracking-wider uppercase mb-0.5">UNMARIS ASET</div>
                        <div class="font-bold text-gray-900 text-sm leading-tight truncate" title="{{ $asset->name }}">
                            {{ $asset->name }}
                        </div>
                        <div class="font-mono text-xs font-semibold text-gray-600 mt-1">
                            {{ $asset->asset_code }}
                        </div>
                        <div class="text-[10px] text-gray-500 mt-0.5 truncate">
                            {{ $asset->location->name ?? 'Gudang' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Auto trigger print dialog (opsional) -->
    <script>
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>