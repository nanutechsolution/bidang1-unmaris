<div class="max-w-4xl mx-auto">
    <!-- Form Container: Glassmorphism Card -->
    <div class="bg-white/90 backdrop-blur-2xl shadow-sm border border-gray-100/50 rounded-[2rem] overflow-hidden">
        
        <div class="px-6 py-5 border-b border-gray-100/80 bg-white">
            <h3 class="text-lg font-bold text-gray-900">Informasi Detail Aset</h3>
            <p class="text-xs text-gray-500 mt-1">Lengkapi data aset dengan benar untuk keperluan audit kampus.</p>
        </div>

        <form wire:submit="save" class="p-6 sm:p-8 space-y-6">
            
            <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2">
                
                <!-- Nama Aset -->
                <div class="sm:col-span-2 group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama / Merek Aset <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium" placeholder="Contoh: Laptop ASUS ROG Strix G15">
                    @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select wire:model="category_id" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium cursor-pointer">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->code }} - {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lokasi Penempatan <span class="text-red-500">*</span></label>
                    <select wire:model="location_id" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium cursor-pointer">
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }} ({{ $location->building }})</option>
                        @endforeach
                    </select>
                    @error('location_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal & Harga dibungkus dalam card abu-abu -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tgl. Pengadaan <span class="text-red-500">*</span></label>
                        <input type="date" wire:model="purchase_date" max="{{ date('Y-m-d') }}" class="block w-full px-4 py-3 bg-white border-0 text-gray-900 rounded-xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium">
                        @error('purchase_date') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nilai Aset (Rp)</label>
                        <input type="number" wire:model="price" class="block w-full px-4 py-3 bg-white border-0 text-gray-900 rounded-xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium" placeholder="0">
                        @error('price') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Status & Kondisi -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status <span class="text-red-500">*</span></label>
                    <select wire:model="status" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium cursor-pointer">
                        <option value="active">🟢 Aktif (Digunakan)</option>
                        <option value="maintenance">🟠 Dalam Perawatan</option>
                        <option value="disposed">⚪ Dihapus / Hibah</option>
                        <option value="lost">🔴 Hilang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kondisi Fisik <span class="text-red-500">*</span></label>
                    <select wire:model="condition" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium cursor-pointer">
                        <option value="good">Sangat Baik</option>
                        <option value="fair">Kurang Baik / Layak</option>
                        <option value="poor">Rusak Ringan</option>
                        <option value="broken">Rusak Berat</option>
                    </select>
                </div>

                <!-- Catatan -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Khusus</label>
                    <textarea wire:model="notes" rows="3" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium resize-none" placeholder="Masukkan detail spesifikasi, nomor seri, atau kelengkapan..."></textarea>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 mt-2 flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('assets.index') }}" wire:navigate class="w-full sm:w-auto text-center px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 bg-unmaris-600 hover:bg-unmaris-700 text-white text-sm font-bold rounded-2xl shadow-[0_4px_12px_rgba(2,132,199,0.2)] transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Simpan Aset Baru
                </button>
            </div>
        </form>
    </div>
</div>