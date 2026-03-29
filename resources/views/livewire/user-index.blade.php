<div class="space-y-6 animate-fade-in">
    
    <!-- Action Bar (Floating Pill Style) -->
    <div class="bg-white/80 backdrop-blur-xl shadow-sm border border-gray-100/50 rounded-3xl p-3 flex flex-col sm:flex-row justify-between items-center gap-4 transition-all z-20 relative">
        <div class="relative w-full sm:w-80 group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-unmaris-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" 
                class="block w-full pl-12 pr-4 py-3 border-0 bg-gray-50/50 hover:bg-gray-100/50 focus:bg-white text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 sm:text-sm transition-all shadow-sm font-bold" 
                placeholder="Cari nama atau email...">
        </div>

        <a href="{{ route('users.create') }}" wire:navigate 
            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-[0_4px_12px_rgba(2,132,199,0.2)] text-sm font-bold rounded-2xl text-white bg-gradient-to-r from-unmaris-600 to-unmaris-500 hover:from-unmaris-700 hover:to-unmaris-600 transition-all hover:scale-[1.02] active:scale-[0.98]">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- VIEW 1: DESKTOP TABLE -->
    <div class="hidden md:block bg-white shadow-sm ring-1 ring-gray-100 rounded-[2rem] overflow-hidden relative z-10">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50/80 backdrop-blur-sm">
                <tr>
                    <th class="py-4 pl-6 pr-3 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Info Pengguna</th>
                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Peran</th>
                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status Akses</th>
                    <th class="py-4 pl-3 pr-6 text-right font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @foreach($users as $user)
                    <tr class="hover:bg-unmaris-50/30 transition-colors group">
                        <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-unmaris-100 to-unmaris-200 flex items-center justify-center text-unmaris-700 font-extrabold shadow-inner group-hover:from-sunmaris-100 group-hover:to-sunmaris-200 transition-colors">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 leading-tight">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 font-medium">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap">
                            @php $roleColors = ['admin' => 'bg-purple-100 text-purple-700 border-purple-200', 'operator' => 'bg-blue-100 text-blue-700 border-blue-200', 'viewer' => 'bg-gray-100 text-gray-700 border-gray-200']; @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-widest {{ $roleColors[$user->role] ?? 'bg-gray-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap">
                            <button wire:click="toggleStatus('{{ $user->id }}')" class="relative inline-flex h-6 w-11 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 {{ $user->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>
                        <td class="py-4 pl-3 pr-6 whitespace-nowrap text-right">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('users.edit', $user->id) }}" wire:navigate class="p-2 text-unmaris-600 hover:bg-unmaris-50 rounded-xl inline-block transition-colors" title="Edit Pengguna">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- VIEW 2: MOBILE CARDS -->
    <div class="md:hidden space-y-4">
        @foreach($users as $user)
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100/50 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-unmaris-50 text-unmaris-700 flex items-center justify-center font-bold shadow-inner">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight truncate">{{ $user->name }}</h3>
                            <p class="text-[10px] text-gray-500 mt-0.5 truncate font-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                    @php $roleColors = ['admin' => 'bg-purple-100 text-purple-700 border-purple-200', 'operator' => 'bg-blue-100 text-blue-700 border-blue-200', 'viewer' => 'bg-gray-100 text-gray-700 border-gray-200']; @endphp
                    <span class="inline-flex py-1 px-2 rounded-lg text-[9px] font-bold border uppercase tracking-widest {{ $roleColors[$user->role] ?? 'bg-gray-100' }}">
                        {{ $user->role }}
                    </span>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Akses:</span>
                        <button wire:click="toggleStatus('{{ $user->id }}')" class="relative inline-flex h-5 w-9 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 {{ $user->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate class="text-[11px] font-bold text-unmaris-600 bg-unmaris-50 hover:bg-unmaris-100 transition-colors px-3 py-1.5 rounded-xl">
                        Edit Profil & Sandi
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="bg-white/50 backdrop-blur-md rounded-2xl p-2 px-4 shadow-sm">
        {{ $users->links() }}
    </div>
</div>