<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card: Info Aset (Glassmorphism subtle) -->
    <div class="bg-white/80 backdrop-blur-xl shadow-sm border border-gray-100 rounded-2xl p-5 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-all">
        <div class="flex items-start gap-4">
            <!-- Icon Box -->
            <div class="hidden sm:flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-unmaris-50 text-unmaris-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">{{ $asset->name }}</h1>
                <p class="text-sm font-medium text-gray-500 mt-1 flex items-center gap-2">
                    <span class="bg-gray-100 text-gray-700 py-0.5 px-2 rounded-md font-mono text-xs">{{ $asset->asset_code }}</span>
                    &bull; {{ $asset->category->name ?? 'Tanpa Kategori' }}
                </p>
            </div>
        </div>

        <!-- Status Label -->
        <!-- Cari bagian Status Label ini -->
        <div class="w-full sm:w-auto flex flex-col sm:items-end gap-3 mt-4 sm:mt-0">
            <div class="text-left sm:text-right">
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    {{ ucfirst($asset->status) }}
                </span>
                <div class="text-xs text-gray-400 mt-1">Kondisi: {{ ucfirst($asset->condition) }}</div>
            </div>

            <!-- TAMBAHKAN TOMBOL CETAK INI -->
            <!-- target="_blank" penting agar layout print tidak menimpa dashboard -->
            <a href="{{ route('assets.print', $asset->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-unmaris-600 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Label QR
            </a>
        </div>
    </div>

    <!-- Form Tambah Catatan (Mobile Friendly) -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-4 sm:p-5">
        <form wire:submit="addNote" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input
                    type="text"
                    wire:model="manual_note"
                    placeholder="Tambahkan catatan riwayat (misal: Selesai kalibrasi bulanan)..."
                    class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-unmaris-500 focus:ring-unmaris-500 sm:text-sm transition-all">
                @error('manual_note')
                <span class="absolute -bottom-5 left-1 text-red-500 text-xs font-medium">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="mt-4 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-unmaris-600 hover:bg-unmaris-700 shadow-sm shadow-unmaris-200 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-unmaris-500">
                <svg wire:loading wire:target="addNote" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Catat
            </button>
        </form>
    </div>

    <!-- Timeline Section -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-5 sm:p-8">
        <h3 class="text-base font-semibold text-gray-900 mb-6">Jejak Rekam Aset</h3>

        <div class="relative">
            <!-- Garis vertikal timeline -->
            <div class="absolute left-4 sm:left-6 top-0 bottom-0 w-px bg-gray-200"></div>

            <div class="space-y-8 relative">
                @forelse($trackings as $track)
                <div class="flex gap-4 sm:gap-6 items-start relative">
                    <!-- Indikator Dot / Icon -->
                    <div class="relative z-10 flex-shrink-0 w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center rounded-full border-[3px] border-white shadow-sm
                            {{ $track->action === 'created' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $track->action === 'updated' || $track->action === 'moved' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $track->action === 'note_added' ? 'bg-gray-100 text-gray-600' : '' }}
                            {{ $track->action === 'disposed' ? 'bg-red-100 text-red-600' : '' }}
                        ">
                        <!-- Icon disesuaikan dengan aksi -->
                        @if($track->action === 'created')
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        @elseif($track->action === 'note_added')
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        @endif
                    </div>

                    <!-- Konten Card Timeline -->
                    <div class="flex-1 pb-1">
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 sm:p-5 hover:bg-gray-100/50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-2">
                                <h4 class="text-sm font-bold text-gray-900">
                                    {{ $track->action === 'created' ? 'Aset Didaftarkan' : 
                                           ($track->action === 'moved' ? 'Pindah Lokasi' : 
                                           ($track->action === 'updated' ? 'Perubahan Data' : 
                                           ($track->action === 'note_added' ? 'Catatan Tambahan' : 'Status Diperbarui'))) }}
                                </h4>
                                <span class="text-xs font-medium text-gray-500">
                                    {{ $track->created_at->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mb-3">{{ $track->notes }}</p>

                            <!-- Menampilkan Diff (Before/After) jika ada perubahan -->
                            @if($track->previous_state && $track->new_state && $track->action !== 'created')
                            <div class="mt-3 bg-white rounded-lg p-3 border border-gray-100 text-xs sm:text-sm font-mono overflow-x-auto">
                                @foreach(array_diff_assoc($track->new_state, $track->previous_state) as $key => $newValue)
                                @if(!in_array($key, ['updated_at', 'created_at']))
                                <div class="grid grid-cols-[100px_1fr] sm:grid-cols-[120px_1fr] gap-2 mb-1 border-b border-gray-50 pb-1 last:border-0 last:pb-0">
                                    <span class="text-gray-500 capitalize">{{ str_replace('_id', '', $key) }}:</span>
                                    <span class="text-gray-800">
                                        <span class="line-through text-red-400 mr-2">{{ $track->previous_state[$key] ?? '-' }}</span>
                                        <span class="text-green-600 font-semibold">{{ $newValue }}</span>
                                    </span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endif

                            <div class="mt-3 flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-unmaris-100 flex items-center justify-center text-[10px] font-bold text-unmaris-700">
                                    {{ substr($track->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="text-xs text-gray-500">Oleh: <span class="font-medium text-gray-700">{{ $track->user->name ?? 'Sistem' }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="ml-12 text-sm text-gray-500 italic">Belum ada riwayat tercatat.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100">
            <a href="{{ route('assets.index') }}" wire:navigate class="text-sm font-medium text-unmaris-600 hover:text-unmaris-800 flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Daftar Aset
            </a>
        </div>
    </div>
</div>