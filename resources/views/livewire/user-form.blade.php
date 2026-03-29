<div class="max-w-3xl mx-auto space-y-6 animate-fade-in pb-10">
    <!-- Breadcrumb (Mobile Friendly) -->
    <div class="flex items-center gap-2 px-4 md:px-0 text-[10px] font-bold uppercase tracking-widest text-gray-400">
        <a href="{{ route('users.index') }}" wire:navigate class="hover:text-unmaris-600 transition-colors">Pengguna</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-unmaris-600">{{ $isEdit ? 'Perbarui' : 'Baru' }}</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white/90 backdrop-blur-2xl shadow-xl shadow-gray-200/50 border border-white rounded-[2.5rem] overflow-hidden relative">
        <!-- Aksen Garis Emas UNMARIS -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sunmaris-500 via-sunmaris-300 to-sunmaris-500"></div>

        <div class="px-8 py-7 border-b border-gray-100/80 bg-white/50">
            <h3 class="text-xl font-extrabold text-unmaris-900 tracking-tight">
                {{ $isEdit ? 'Edit Profil Pengguna' : 'Registrasi Pengguna Baru' }}
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-medium">Atur kredensial dan hak akses staf Universitas Stella Maris Sumba.</p>
        </div>

        <form wire:submit="save" class="p-8 sm:p-10 space-y-8">
            <div class="grid grid-cols-1 gap-y-7 gap-x-8 sm:grid-cols-2">
                
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2 group">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" wire:model="name" 
                            class="block w-full px-5 py-4 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-100 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold shadow-sm" 
                            placeholder="Masukkan nama lengkap staf...">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-unmaris-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                    </div>
                    @error('name') <span class="text-red-500 text-[10px] mt-2 block font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="sm:col-span-2 group">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email Kampus <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="email" wire:model="email" 
                            class="block w-full px-5 py-4 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-100 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold shadow-sm" 
                            placeholder="staf@unmaris.ac.id">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-unmaris-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" /></svg>
                        </div>
                    </div>
                    @error('email') <span class="text-red-500 text-[10px] mt-2 block font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Role & Status Section -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 bg-unmaris-50/30 p-6 rounded-[2rem] border border-unmaris-100/50">
                    <div>
                        <label class="block text-[10px] font-bold text-unmaris-700 uppercase tracking-widest mb-2 ml-1">Hak Akses Sistem</label>
                        <select wire:model="role" class="block w-full px-5 py-4 bg-white border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-unmaris-100 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold cursor-pointer shadow-sm">
                            <option value="viewer">Viewer (Hanya Lihat)</option>
                            <option value="operator">Operator (Kelola Aset)</option>
                            <option value="admin">Administrator (Akses Penuh)</option>
                        </select>
                        @error('role') <span class="text-red-500 text-[10px] mt-2 block font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-unmaris-700 uppercase tracking-widest mb-2 ml-1">Status Akun</label>
                        <select wire:model="is_active" class="block w-full px-5 py-4 bg-white border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-unmaris-100 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold cursor-pointer shadow-sm">
                            <option value="1">Aktif (Izinkan Login)</option>
                            <option value="0">Nonaktif (Blokir Akses)</option>
                        </select>
                    </div>
                </div>

                <!-- Password Area -->
                <div class="sm:col-span-2 space-y-4 pt-2">
                    <div class="flex items-center justify-between px-1">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            {{ $isEdit ? 'Reset Kata Sandi' : 'Kata Sandi Default' }} 
                            @if(!$isEdit) <span class="text-red-500">*</span> @endif
                        </label>
                        @if($isEdit)
                            <span class="text-[9px] font-bold text-sunmaris-600 uppercase bg-sunmaris-50 px-2.5 py-1 rounded-lg border border-sunmaris-100">Kosongkan jika tidak diganti</span>
                        @endif
                    </div>
                    <div class="relative group" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" wire:model="password" 
                            class="block w-full px-5 py-4 bg-gray-50/50 border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-bold shadow-sm" 
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-4 flex items-center text-gray-300 hover:text-unmaris-500 transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-[10px] mt-1 block font-bold ml-1">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-8 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-4">
                <a href="{{ route('users.index') }}" wire:navigate 
                    class="w-full sm:w-auto text-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all shadow-sm">
                    Batal
                </a>
                <button type="submit" 
                    class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-4 bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 text-white text-sm font-extrabold rounded-2xl shadow-xl shadow-unmaris-200 transition-all hover:scale-[1.02] active:scale-[0.98] tracking-tight">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Daftarkan Akun' }}
                </button>
            </div>
        </form>
    </div>
</div>