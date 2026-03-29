<div class="space-y-6 animate-fade-in">
    
    <!-- Action Bar (Floating Pill Style) -->
    <div class="bg-white/80 backdrop-blur-xl shadow-sm border border-gray-100/50 rounded-3xl p-3 flex flex-col sm:flex-row justify-between items-center gap-4 transition-all z-20 relative">
        <div class="relative w-full sm:w-80 group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-unmaris-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" 
                class="block w-full pl-12 pr-4 py-3 border-0 bg-gray-50/50 hover:bg-gray-100/50 focus:bg-white text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 sm:text-sm transition-all shadow-sm font-bold" 
                placeholder="Cari judul survei...">
        </div>

        <a href="{{ route('survey.create') }}" wire:navigate 
            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-[0_4px_12px_rgba(2,132,199,0.2)] text-sm font-bold rounded-2xl text-white bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 transition-all hover:scale-[1.02] active:scale-[0.98]">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Buat Survei Baru
        </a>
    </div>

    <!-- VIEW 1: DESKTOP TABLE -->
    <div class="hidden md:block bg-white shadow-sm ring-1 ring-gray-100 rounded-[2rem] overflow-hidden relative z-10">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50/80 backdrop-blur-sm">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Informasi Survei</th>
                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Responden</th>
                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                    <th class="py-4 pl-3 pr-6 text-right font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @forelse($surveys as $survey)
                    <tr class="hover:bg-unmaris-50/30 transition-colors group">
                        <td class="py-4 pl-6 pr-3">
                            <div class="flex items-start gap-4">
                                <div class="h-10 w-10 shrink-0 rounded-xl bg-gradient-to-br from-unmaris-100 to-unmaris-200 flex items-center justify-center text-unmaris-700 font-extrabold shadow-inner group-hover:from-sunmaris-100 group-hover:to-sunmaris-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 leading-tight">{{ $survey->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1 font-medium line-clamp-1">{{ $survey->description ?? 'Tidak ada deskripsi.' }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1 font-bold tracking-wider uppercase">Dibuat: {{ $survey->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-xs font-bold bg-unmaris-50 text-unmaris-700 border border-unmaris-100">
                                {{ number_format($survey->responses_count) }} Orang
                            </span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap">
                            <button wire:click="toggleStatus('{{ $survey->id }}')" class="relative inline-flex h-6 w-11 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $survey->is_active ? 'bg-green-500' : 'bg-gray-300' }}" title="Klik untuk mengubah status">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 {{ $survey->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>
                        <td class="py-4 pl-3 pr-6 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                <!-- Tombol Salin Link Publik -->
                                <button onclick="navigator.clipboard.writeText('{{ url('/survei/' . $survey->id) }}'); alert('Link survei berhasil disalin!');" class="p-2 text-gray-400 hover:text-unmaris-600 hover:bg-unmaris-50 rounded-xl transition-colors" title="Salin Link Publik">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                </button>
                                
                                <!-- Tombol Edit -->
                                <a href="{{ route('survey.edit', $survey->id) }}" wire:navigate class="p-2 text-gray-400 hover:text-sunmaris-600 hover:bg-sunmaris-50 rounded-xl transition-colors" title="Edit Pertanyaan">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>

                                <!-- Tombol Hapus -->
                                <button wire:click="delete('{{ $survey->id }}')" wire:confirm="Yakin ingin menghapus survei ini? Semua data jawaban dari responden juga akan terhapus permanen." class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus Survei">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-400 font-bold">Belum ada survei yang dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- VIEW 2: MOBILE CARDS -->
    <div class="md:hidden space-y-4">
        @forelse($surveys as $survey)
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100/50 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $survey->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-start gap-3 w-full">
                        <div class="h-10 w-10 shrink-0 rounded-xl bg-unmaris-50 text-unmaris-700 flex items-center justify-center font-bold shadow-inner">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight pr-2">{{ $survey->title }}</h3>
                            <p class="text-[10px] text-gray-500 mt-1 line-clamp-1 font-medium">{{ $survey->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="bg-gray-50 rounded-xl p-2 text-center border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest">Responden</span>
                        <span class="block text-xs font-extrabold text-unmaris-700 mt-0.5">{{ number_format($survey->responses_count) }}</span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-2 flex flex-col items-center justify-center border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</span>
                        <button wire:click="toggleStatus('{{ $survey->id }}')" class="relative inline-flex h-5 w-9 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $survey->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 {{ $survey->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50 gap-2">
                    <button onclick="navigator.clipboard.writeText('{{ url('/survei/' . $survey->id) }}'); alert('Link disalin!');" class="flex-1 flex justify-center items-center gap-2 text-[10px] font-bold text-gray-600 bg-gray-50 hover:bg-gray-100 transition-colors px-3 py-2.5 rounded-xl border border-gray-100">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        Salin Link
                    </button>
                    <a href="{{ route('survey.edit', $survey->id) }}" wire:navigate class="flex-1 flex justify-center items-center gap-2 text-[10px] font-bold text-unmaris-700 bg-unmaris-50 hover:bg-unmaris-100 transition-colors px-3 py-2.5 rounded-xl border border-unmaris-100">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Edit
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white/50 rounded-3xl border border-dashed border-gray-200 text-gray-400 font-bold text-sm">
                Belum ada survei yang dibuat.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="bg-white/50 backdrop-blur-md rounded-2xl p-2 px-4 shadow-sm">
        {{ $surveys->links() }}
    </div>
</div>