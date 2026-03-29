<div class="max-w-4xl mx-auto space-y-6 pb-12 animate-fade-in">
    
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 px-4 md:px-0 text-[10px] font-bold uppercase tracking-widest text-gray-400">
        <a href="{{ route('survey.results') }}" wire:navigate class="hover:text-unmaris-600 transition-colors">Manajemen Survei</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-unmaris-600">{{ $survey ? 'Edit Survei' : 'Buat Survei Baru' }}</span>
    </div>

    <form wire:submit="save" class="space-y-6">
        
        <!-- KARTU 1: PENGATURAN SURVEI -->
        <div class="bg-white/90 backdrop-blur-2xl shadow-sm ring-1 ring-gray-100 rounded-[2rem] overflow-hidden relative">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-unmaris-600"></div>
            
            <div class="p-8 space-y-6">
                <div>
                    <input type="text" wire:model="title" 
                        class="block w-full border-0 bg-transparent text-gray-900 focus:ring-0 text-3xl font-extrabold tracking-tight placeholder-gray-300 p-0" 
                        placeholder="Judul Survei (Misal: Evaluasi Fasilitas Lab 2026)">
                    @error('title') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <textarea wire:model="description" rows="2" 
                        class="block w-full border-0 bg-transparent text-gray-600 focus:ring-0 font-medium placeholder-gray-300 p-0 resize-none" 
                        placeholder="Deskripsi atau instruksi untuk responden (Opsional)..."></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Status Publikasi</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                        <span class="ml-3 text-sm font-bold text-gray-900">Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- KARTU 2: BLOK PERTANYAAN DINAMIS -->
        <div class="space-y-4">
            @foreach($questions as $index => $question)
                <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-[2rem] p-6 relative group transition-all hover:shadow-md">
                    
                    <!-- Handle Kiri (Dekorasi) -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-12 bg-gray-200 rounded-r-lg group-hover:bg-sunmaris-400 transition-colors cursor-move"></div>

                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        
                        <!-- Input Pertanyaan -->
                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <input type="text" wire:model="questions.{{ $index }}.question_text" 
                                    class="block w-full px-4 py-4 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-100 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold text-lg" 
                                    placeholder="Tuliskan pertanyaan Anda di sini...">
                                @error('questions.'.$index.'.question_text') <span class="text-red-500 text-[10px] mt-2 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-50">
                                
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <select wire:model="questions.{{ $index }}.type" class="block w-full sm:w-48 px-4 py-3 bg-white border-0 text-gray-900 rounded-xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold text-sm cursor-pointer shadow-sm">
                                        <option value="rating">Rating Bintang (1-5)</option>
                                        <option value="text">Teks Panjang (Komentar)</option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-end gap-6 w-full sm:w-auto">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" wire:model="questions.{{ $index }}.is_required" class="w-4 h-4 text-unmaris-600 rounded border-gray-300 focus:ring-unmaris-500 cursor-pointer">
                                        <span class="text-xs font-bold text-gray-600">Wajib Diisi</span>
                                    </label>

                                    <!-- Tombol Hapus Pertanyaan -->
                                    <button type="button" wire:click="removeQuestion({{ $index }})" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="Hapus Pertanyaan">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- TOMBOL TAMBAH PERTANYAAN -->
        <button type="button" wire:click="addQuestion" class="w-full flex justify-center items-center py-4 px-4 border-2 border-dashed border-gray-300 rounded-[2rem] text-sm font-bold text-gray-500 hover:text-unmaris-600 hover:border-unmaris-400 hover:bg-unmaris-50 transition-all">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Pertanyaan Baru
        </button>

        <!-- FLOATING ACTION BAR BAWAH -->
        <div class="fixed bottom-0 left-0 right-0 md:left-72 z-40 p-4 bg-white/80 backdrop-blur-md border-t border-gray-100 flex justify-end gap-4">
            <a href="{{ route('survey.results') }}" wire:navigate class="px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all">
                Batal
            </a>
            <button type="submit" class="inline-flex justify-center items-center px-10 py-3.5 bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 text-white text-sm font-extrabold rounded-2xl shadow-lg transition-all hover:scale-[1.02] active:scale-[0.98]">
                <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Simpan & Publikasikan
            </button>
        </div>
    </form>
</div>