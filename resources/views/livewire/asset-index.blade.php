<div class="space-y-6 animate-fade-in">
    
    <!-- Top Action Bar (Floating Pill Style) -->
    <div class="bg-white/80 backdrop-blur-xl shadow-sm border border-gray-100/50 rounded-3xl p-3 flex flex-col sm:flex-row justify-between items-center gap-4 transition-all z-20 relative">
        
        <!-- Search & Filter Area -->
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-unmaris-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input 
                    wire:model.live.debounce.500ms="search" 
                    type="text" 
                    class="block w-full pl-12 pr-4 py-3 border-0 bg-gray-50/50 hover:bg-gray-100/50 focus:bg-white text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 sm:text-sm transition-all duration-300" 
                    placeholder="Cari kode atau nama aset..."
                >
            </div>

            <select wire:model.live="status" class="block w-full sm:w-48 py-3 px-4 border-0 bg-gray-50/50 hover:bg-gray-100/50 focus:bg-white text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 sm:text-sm transition-all cursor-pointer font-medium">
                <option value="">Semua Status</option>
                <option value="active">🟢 Aktif</option>
                <option value="maintenance">🟠 Perawatan</option>
                <option value="disposed">⚪ Dihapus</option>
                <option value="lost">🔴 Hilang</option>
            </select>
        </div>

        @can('edit-assets')
            <a href="{{ route('assets.create') }}" wire:navigate class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-[0_4px_12px_rgba(2,132,199,0.2)] text-sm font-bold rounded-2xl text-white bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unmaris-500 transition-all hover:scale-[1.02] active:scale-[0.98]">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                Tambah Aset
            </a>
        @endcan
    </div>

    <!-- =========================================
         VIEW 1: DESKTOP TABLE (Layar Medium ke atas)
         ========================================= -->
    <div class="hidden md:block bg-white shadow-sm ring-1 ring-gray-100 rounded-3xl overflow-hidden relative z-10">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/80 backdrop-blur-sm">
                <tr>
                    <th scope="col" class="py-4 pl-6 pr-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Aset</th>
                    <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative py-4 pl-3 pr-6 text-right"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @forelse($assets as $asset)
                    <tr class="hover:bg-unmaris-50/30 transition-colors group">
                        <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <!-- Ikon Dummy Berdasarkan Huruf Pertama -->
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-500 font-bold shadow-inner group-hover:from-unmaris-100 group-hover:to-unmaris-200 group-hover:text-unmaris-600 transition-colors">
                                    {{ substr($asset->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">{{ $asset->name }}</span>
                                    <span class="text-xs font-mono text-gray-500 mt-0.5">{{ $asset->asset_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                            {{ $asset->category->name ?? '-' }}
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-800">{{ $asset->location->name ?? '-' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $asset->location->building ?? '' }}</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap">
                            @php
                                $colors = ['active' => 'bg-green-100 text-green-700', 'maintenance' => 'bg-orange-100 text-orange-700', 'disposed' => 'bg-gray-100 text-gray-700', 'lost' => 'bg-red-100 text-red-700'];
                                $labels = ['active' => 'Aktif', 'maintenance' => 'Perawatan', 'disposed' => 'Dihapus', 'lost' => 'Hilang'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-xl text-xs font-bold {{ $colors[$asset->status] ?? 'bg-gray-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_replace(['bg-', '-100'], ['bg-', '-500'], explode(' ', $colors[$asset->status])[0]) }}"></span>
                                {{ $labels[$asset->status] ?? ucfirst($asset->status) }}
                            </span>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @can('edit-assets')
                                    <a href="{{ route('assets.edit', $asset->id) }}" wire:navigate class="p-2 text-unmaris-600 hover:bg-unmaris-50 rounded-xl transition-colors" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                @endcan
                                <a href="{{ route('assets.history', $asset->id) }}" wire:navigate class="p-2 text-gray-500 hover:text-unmaris-600 hover:bg-gray-100 rounded-xl transition-colors" title="Lihat Riwayat">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-12 text-center text-gray-400">Tidak ada aset ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- =========================================
         VIEW 2: MOBILE CARDS (Layar Kecil / HP)
         ========================================= -->
    <div class="md:hidden space-y-4">
        @forelse($assets as $asset)
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100/50 relative overflow-hidden">
                <!-- Color Bar Kiri -->
                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $asset->status === 'active' ? 'bg-green-400' : ($asset->status === 'maintenance' ? 'bg-orange-400' : 'bg-gray-300') }}"></div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 pr-4">
                        <h3 class="text-base font-bold text-gray-900 leading-tight truncate">{{ $asset->name }}</h3>
                        <p class="text-xs font-mono text-gray-500 mt-1">{{ $asset->asset_code }}</p>
                    </div>
                    @php
                        $colors = ['active' => 'bg-green-100 text-green-700', 'maintenance' => 'bg-orange-100 text-orange-700', 'disposed' => 'bg-gray-100 text-gray-700', 'lost' => 'bg-red-100 text-red-700'];
                    @endphp
                    <span class="inline-flex py-1 px-2.5 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $colors[$asset->status] ?? 'bg-gray-100' }}">
                        {{ $labels[$asset->status] ?? $asset->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-5 text-sm">
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 uppercase font-bold mb-0.5">Lokasi</span>
                        <span class="font-medium text-gray-800 truncate block">{{ $asset->location->name ?? '-' }}</span>
                    </div>
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                        <span class="block text-[10px] text-gray-400 uppercase font-bold mb-0.5">Kategori</span>
                        <span class="font-medium text-gray-800 truncate block">{{ $asset->category->name ?? '-' }}</span>
                    </div>
                </div>

                <!-- Action Buttons Full Width -->
                <div class="flex gap-2">
                    <a href="{{ route('assets.history', $asset->id) }}" wire:navigate class="flex-1 flex justify-center items-center py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                        Riwayat Aset
                    </a>
                    @can('edit-assets')
                        <a href="{{ route('assets.edit', $asset->id) }}" wire:navigate class="flex-1 flex justify-center items-center py-2.5 bg-unmaris-50 hover:bg-unmaris-100 text-unmaris-700 text-xs font-bold rounded-xl transition-colors">
                            Edit Data
                        </a>
                    @endcan
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400 bg-white rounded-3xl border border-dashed border-gray-200">
                Tidak ada data.
            </div>
        @endforelse
    </div>

    <!-- Pagination Modern -->
    <div class="bg-white/50 backdrop-blur-md rounded-2xl p-2 px-4 shadow-sm">
        {{ $assets->links() }}
    </div>
</div>