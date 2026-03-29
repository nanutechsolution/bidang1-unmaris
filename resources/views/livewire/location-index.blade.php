<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 animate-fade-in">

    <!-- KOLOM KIRI: FORM -->
    <div class="lg:col-span-1">
        <div class="bg-white/90 backdrop-blur-2xl shadow-sm border border-gray-100/50 rounded-[2rem] p-6 lg:sticky lg:top-28">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-unmaris-900">{{ $isEdit ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h3>
                <p class="text-xs text-gray-500 mt-1">Kelola data gedung dan ruangan kampus.</p>
            </div>

            <form wire:submit="save" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Gedung <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="building" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium" placeholder="Cth: Gedung Rektorat">
                    @error('building') <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Ruangan <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium" placeholder="Cth: Lab Komputer A">
                    @error('name') <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Ruangan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" wire:model="room_number" class="block w-full px-4 py-3 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium uppercase" placeholder="Cth: R-101">
                </div>

                <div class="pt-4 flex gap-2">
                    @if($isEdit)
                    <button type="button" wire:click="resetFields" class="w-full px-4 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all">Batal</button>
                    @endif
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3.5 bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 text-white text-sm font-bold rounded-2xl shadow-md transition-all active:scale-95">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $isEdit ? 'Simpan' : 'Tambah Baru' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- KOLOM KANAN: LIST DATA -->
    <div class="lg:col-span-2 space-y-4">

        <div class="relative w-full group mb-6">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-unmaris-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-12 pr-4 py-3.5 border-0 bg-white shadow-sm text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-100 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 sm:text-sm transition-all" placeholder="Cari gedung atau ruangan...">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($locations as $location)
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100/50 hover:shadow-md transition-shadow relative overflow-hidden group">
                <!-- Icon Decoration Bulat -->
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-gray-50 rounded-full z-0 group-hover:bg-sunmaris-100 transition-colors"></div>

                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <span class="inline-flex py-1 px-2.5 rounded-lg text-[10px] font-bold text-gray-600 bg-gray-100 mb-2">
                            {{ $location->building }}
                        </span>
                        <h3 class="text-base font-bold text-gray-900 leading-tight">{{ $location->name }}</h3>
                        <p class="text-xs font-mono text-unmaris-600 font-bold mt-1.5">{{ $location->room_number ?? 'NO-ROOM' }}</p>
                    </div>

                    <div class="flex gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity flex-col">
                        <button wire:click="edit('{{ $location->id }}')" class="p-2 bg-white shadow-sm border border-gray-100 hover:border-unmaris-200 text-gray-500 hover:text-unmaris-600 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button wire:click="delete('{{ $location->id }}')" wire:confirm="Yakin ingin menghapus lokasi ini?" class="p-2 bg-white shadow-sm border border-gray-100 hover:border-red-200 text-gray-500 hover:text-red-600 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="sm:col-span-2 text-center py-10 bg-white/50 rounded-3xl border border-dashed border-gray-200 text-gray-400">
                Tidak ada lokasi ditemukan.
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $locations->links() }}
        </div>
    </div>
</div>