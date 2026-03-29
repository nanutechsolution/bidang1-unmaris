<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f4f7f6]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SI Aset | UNMARIS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-gray-900 overflow-hidden flex" x-data="{ mobileMenuOpen: false }">

    <!-- Panggil Toast Component -->
    <x-toast />

    <!-- ==========================================
         DESKTOP SIDEBAR (Floating Capsule 2026)
    =========================================== -->
    <aside class="hidden md:flex flex-col w-72 bg-unmaris-900 text-white m-4 rounded-[2rem] shadow-2xl relative overflow-hidden flex-shrink-0 z-20 border border-unmaris-800">
        <!-- Aksen Garis Emas di atas -->
        <div class="absolute top-0 left-0 w-full h-1 bg-sunmaris-500 z-30"></div>
        <!-- Aksen Kaca (Glassmorphism Decoration) -->
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-white/5 to-transparent z-0"></div>

        <div class="h-28 flex items-center px-8 border-b border-white/10 relative z-10 pt-2">
            <!-- Logo UNMARIS -->
            <div class="w-12 h-12 mr-4 flex-shrink-0 bg-white p-1 rounded-xl shadow-[0_0_15px_rgba(250,204,21,0.2)]">
                <img src="{{ asset('logo.png') }}" alt="Logo UNMARIS" class="w-full h-full object-contain drop-shadow-sm" />
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wider leading-tight text-white">SI ASET</h1>
                <p class="text-[10px] text-sunmaris-400 font-bold uppercase tracking-widest mt-0.5">Stella Maris</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto no-scrollbar relative z-10">
            <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'bg-unmaris-800/80 text-sunmaris-400 shadow-inner border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <p class="px-4 text-[10px] font-bold text-unmaris-400/70 uppercase tracking-widest mt-6 mb-2">Manajemen</p>

            <a href="{{ route('assets.index') }}" wire:navigate class="{{ request()->routeIs('assets.*') ? 'bg-unmaris-800/80 text-sunmaris-400 shadow-inner border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Master Aset
            </a>
            <a href="{{ route('categories.index') }}" wire:navigate class="{{ request()->routeIs('categories.*') ? 'bg-unmaris-800/80 text-sunmaris-400 shadow-inner border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kategori Aset
            </a>
            <a href="{{ route('locations.index') }}" wire:navigate class="{{ request()->routeIs('locations.*') ? 'bg-unmaris-800/80 text-sunmaris-400 shadow-inner border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Lokasi & Ruangan
            </a>

            <a href="{{ route('survey.results') }}" wire:navigate class="{{ request()->routeIs('survey.*') ? 'bg-unmaris-800/80 text-sunmaris-400 border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                Manajemen Survei
            </a>
            @can('manage-users')
            <div class=" pt-6 mt-6 border-t border-white/10">
                <p class="px-4 text-[10px] font-bold text-unmaris-400 uppercase tracking-widest mb-2">Administrator</p>
                <a href="{{ route('users.index') }}" wire:navigate class="{{ request()->routeIs('users.*') ? 'bg-unmaris-800/80 text-sunmaris-400 shadow-inner border border-white/5' : 'text-unmaris-100 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Pengguna & Hak Akses
                </a>
            </div>
            @endcan
        </nav>

        <!-- User Profile -->
        <div class="p-4 relative z-10">
            <div class="bg-unmaris-800/50 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-full bg-sunmaris-500 flex items-center justify-center font-bold text-unmaris-900 shadow-inner">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Pengguna' }}</p>
                    <p class="text-[10px] uppercase font-bold text-unmaris-300 truncate">{{ auth()->user()->role ?? 'viewer' }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-red-400 hover:text-white hover:bg-red-500/50 rounded-xl transition-all" title="Keluar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ==========================================
         MAIN CONTENT AREA
    =========================================== -->
    <main class="flex-1 h-full overflow-y-auto relative w-full md:pb-0 pb-24 scroll-smooth">

        <!-- Mobile Topbar Header -->
        <header class="md:hidden sticky top-0 z-30 bg-white/90 backdrop-blur-xl border-b border-gray-100 px-5 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg">
                    <img src="{{ asset('logo.png') }}" alt="UNMARIS" class="w-full h-full object-contain" />
                </div>
                <div>
                    <h2 class="text-sm font-bold text-unmaris-900 leading-tight">SI ASET</h2>
                    <p class="text-[10px] text-gray-500 uppercase">{{ $header ?? 'Dashboard' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 bg-gray-50 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </header>

        <!-- Desktop Header -->
        <header class="hidden md:flex h-24 px-8 items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                {{ $header ?? 'Dashboard' }}
            </h2>
            <div class="flex items-center gap-4 text-sm font-bold text-unmaris-600 bg-white px-5 py-2.5 rounded-2xl shadow-sm border border-gray-100">
                <svg class="w-5 h-5 text-sunmaris-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ now()->translatedFormat('d F Y') }}
            </div>
        </header>

        <div class="p-4 sm:p-6 md:p-8 pt-6 md:pt-0 w-full max-w-7xl mx-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- ==========================================
         MOBILE BOTTOM NAVIGATION (Biru Navy)
    =========================================== -->
    <nav class="md:hidden fixed bottom-4 left-4 right-4 z-40 bg-unmaris-900/95 backdrop-blur-2xl border border-unmaris-800 shadow-[0_8px_30px_rgba(11,17,43,0.4)] rounded-[2rem] px-6 py-2 flex justify-between items-center">

        <!-- Tombol Beranda -->
        <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all {{ request()->routeIs('dashboard') ? 'text-sunmaris-400' : 'text-unmaris-100 hover:text-white' }}">
            <svg class="w-6 h-6 mb-1 {{ request()->routeIs('dashboard') ? 'stroke-[2.5px]' : 'stroke-2' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>

        <!-- Tombol Utama Warna Emas (Aset) -->
        <a href="{{ route('assets.index') }}" wire:navigate class="relative -top-6 flex flex-col items-center justify-center w-16 h-16 bg-gradient-to-tr from-sunmaris-500 to-sunmaris-300 text-unmaris-900 rounded-full shadow-[0_8px_20px_rgba(234,179,8,0.4)] border-4 border-[#f4f7f6] transition-transform active:scale-95">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </a>

        <!-- Tombol Menu Lainnya (Buka Bottom Sheet) -->
        <button @click="mobileMenuOpen = true" class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all text-unmaris-100 hover:text-white focus:outline-none">
            <svg class="w-6 h-6 mb-1 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-[10px] font-bold">Menu</span>
        </button>

    </nav>

    <!-- ==========================================
         MOBILE MENU OVERLAY (Bottom Sheet)
    =========================================== -->
    <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden fixed inset-0 z-50 flex flex-col justify-end">
        <!-- Latar Gelap (Backdrop) -->
        <div x-show="mobileMenuOpen" x-transition.opacity @click="mobileMenuOpen = false" class="absolute inset-0 bg-unmaris-900/80 backdrop-blur-sm"></div>

        <!-- Konten Sheet -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="relative bg-white rounded-t-[2.5rem] p-6 pb-10 shadow-2xl w-full max-h-[85vh] overflow-y-auto">

            <!-- Pull Handle -->
            <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6"></div>

            <!-- Header Profil -->
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="w-12 h-12 rounded-full bg-sunmaris-500 flex items-center justify-center font-bold text-unmaris-900 text-lg shadow-inner">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900 text-base truncate">{{ auth()->user()->name ?? 'Pengguna' }}</h3>
                    <p class="text-[10px] font-bold text-unmaris-600 uppercase tracking-widest mt-0.5">{{ auth()->user()->role ?? 'viewer' }}</p>
                </div>
                <button @click="mobileMenuOpen = false" class="p-2.5 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Daftar Menu -->
            <div class="space-y-2 mb-8">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-3">Master Data</p>

                <a @click="mobileMenuOpen = false" href="{{ route('categories.index') }}" wire:navigate class="flex items-center gap-4 p-3 rounded-2xl hover:bg-unmaris-50 transition-colors {{ request()->routeIs('categories.*') ? 'bg-unmaris-50 text-unmaris-700' : 'text-gray-600' }}">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-unmaris-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="font-bold text-sm">Kategori Aset</span>
                </a>

                <a @click="mobileMenuOpen = false" href="{{ route('locations.index') }}" wire:navigate class="flex items-center gap-4 p-3 rounded-2xl hover:bg-unmaris-50 transition-colors {{ request()->routeIs('locations.*') ? 'bg-unmaris-50 text-unmaris-700' : 'text-gray-600' }}">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-unmaris-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-bold text-sm">Lokasi & Ruangan</span>
                </a>


                <a @click="mobileMenuOpen = false" href="{{ route('survey.results') }}" wire:navigate class="flex flex-col items-center gap-3 p-5 rounded-3xl bg-gray-50 border border-gray-100 transition-all active:scale-95 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-md flex items-center justify-center text-unmaris-600 border border-unmaris-50">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-xs text-unmaris-900 tracking-tight text-center">Manajemen Survei</span>
                </a>

                @can('manage-users')
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mt-6 mb-3">Administrator</p>
                <a @click="mobileMenuOpen = false" href="{{ route('users.index') }}" wire:navigate class="flex items-center gap-4 p-3 rounded-2xl hover:bg-unmaris-50 transition-colors {{ request()->routeIs('users.*') ? 'bg-unmaris-50 text-unmaris-700' : 'text-gray-600' }}">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-unmaris-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-sm">Pengguna & Hak Akses</span>
                </a>
                @endcan
            </div>

            <!-- Tombol Keluar -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-2xl transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar dari Sistem
                </button>
            </form>

        </div>
    </div>
</body>

</html>