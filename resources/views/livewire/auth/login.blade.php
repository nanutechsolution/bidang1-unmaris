<div class="bg-white/10 backdrop-blur-xl border border-white/10 shadow-2xl rounded-[2.5rem] p-8 sm:p-12 relative overflow-hidden">
    <!-- Dekorasi Cahaya Kuning Halus di Belakang Logo -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-64 bg-sunmaris-500/20 blur-[80px] rounded-full pointer-events-none"></div>

    <div class="text-center mb-10 relative z-10">
        <!-- Menampilkan Logo Asli UNMARIS -->
        <div class="w-28 h-28 mx-auto mb-6 bg-white p-2 rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.2)] transform hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('logo.png') }}" alt="Logo UNMARIS" class="w-full h-full object-contain" />
        </div>
        
        <h2 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-md">SI ASET</h2>
        <p class="text-sunmaris-400 mt-1.5 text-sm font-bold tracking-widest uppercase">Universitas Stella Maris</p>
    </div>

    <form wire:submit="authenticate" class="space-y-6 relative z-10">
        <div>
            <label class="block text-xs font-bold text-unmaris-200 uppercase tracking-wider">Alamat Email</label>
            <input type="email" wire:model="email" class="mt-2 block w-full rounded-2xl border-0 bg-unmaris-900/50 py-3.5 px-5 text-white placeholder-unmaris-400 ring-1 ring-inset ring-white/20 focus:ring-2 focus:ring-inset focus:ring-sunmaris-400 sm:text-sm transition-all font-medium" placeholder="admin@unmaris.ac.id">
            @error('email') <span class="text-red-400 text-xs mt-1.5 block font-bold">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-unmaris-200 uppercase tracking-wider">Kata Sandi</label>
            <input type="password" wire:model="password" class="mt-2 block w-full rounded-2xl border-0 bg-unmaris-900/50 py-3.5 px-5 text-white placeholder-unmaris-400 ring-1 ring-inset ring-white/20 focus:ring-2 focus:ring-inset focus:ring-sunmaris-400 sm:text-sm transition-all font-medium" placeholder="••••••••">
            @error('password') <span class="text-red-400 text-xs mt-1.5 block font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between pt-2">
            <div class="flex items-center">
                <input id="remember" type="checkbox" wire:model="remember" class="h-4 w-4 rounded border-white/20 text-sunmaris-500 focus:ring-sunmaris-500 bg-unmaris-900/50 cursor-pointer">
                <label for="remember" class="ml-2 block text-sm text-unmaris-200 cursor-pointer">Ingat sesi saya</label>
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-[0_8px_20px_rgba(250,204,21,0.25)] text-sm font-extrabold text-unmaris-900 bg-gradient-to-r from-sunmaris-400 to-sunmaris-500 hover:from-sunmaris-300 hover:to-sunmaris-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-unmaris-900 focus:ring-sunmaris-500 transition-all hover:-translate-y-0.5">
            <svg wire:loading wire:target="authenticate" class="animate-spin -ml-1 mr-2 h-5 w-5 text-unmaris-900" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span wire:loading.remove wire:target="authenticate">Masuk Sistem</span>
            <span wire:loading wire:target="authenticate">Memverifikasi...</span>
        </button>
    </form>
</div>