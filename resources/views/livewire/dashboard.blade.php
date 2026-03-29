<div class="space-y-6">
    
    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Total Aset -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4 transition-all hover:shadow-md">
            <div class="p-3 bg-unmaris-50 text-unmaris-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Aset</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalAssets, 0, ',', '.') }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
            </div>
        </div>

        <!-- Total Nilai -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4 transition-all hover:shadow-md">
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Estimasi Nilai Aset</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalValue / 1000000, 1, ',', '.') }}<span class="text-sm font-normal text-gray-400">Jt</span></h3>
            </div>
        </div>

        <!-- Aktif -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4 transition-all hover:shadow-md">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Status Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($activeAssets, 0, ',', '.') }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
            </div>
        </div>

        <!-- Perawatan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4 transition-all hover:shadow-md">
            <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Sedang Perawatan</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($maintenanceAssets, 0, ',', '.') }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
            </div>
        </div>
    </div>

    <!-- Layout Kolom Bawah -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kondisi Kesehatan Aset (Progress Bar CSS) -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-6">Indeks Kesehatan Fisik</h3>
            
            <div class="flex items-center justify-center mb-6 relative">
                <!-- Circular Progress Ring (CSS Trick) -->
                <svg class="w-32 h-32 transform -rotate-90">
                    <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-100" />
                    <!-- Dasharray formula: 2 * PI * r = 351.86 -->
                    <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" class="{{ $healthPercentage > 70 ? 'text-green-500' : 'text-orange-500' }}" stroke-dasharray="351.86" stroke-dashoffset="{{ 351.86 - (351.86 * $healthPercentage / 100) }}" stroke-linecap="round" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-bold text-gray-800">{{ $healthPercentage }}%</span>
                    <span class="text-[10px] text-gray-400 font-medium uppercase">Baik</span>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-600">Kondisi Baik</span>
                        <span class="font-bold text-gray-900">{{ $goodCondition }} Unit</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalAssets > 0 ? ($goodCondition/$totalAssets)*100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-600">Rusak (Ringan/Berat)</span>
                        <span class="font-bold text-gray-900">{{ $brokenCondition }} Unit</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalAssets > 0 ? ($brokenCondition/$totalAssets)*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-base font-bold text-gray-900">Aktivitas Terkini</h3>
                <a href="{{ route('assets.index') }}" wire:navigate class="text-sm font-medium text-unmaris-600 hover:text-unmaris-800">Lihat Semua Aset</a>
            </div>
            
            <div class="space-y-5">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="w-10 h-10 rounded-full bg-unmaris-50 flex items-center justify-center text-unmaris-600 flex-shrink-0">
                            @if($activity->action === 'created')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            @elseif($activity->action === 'moved')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $activity->asset->name ?? 'Aset Dihapus' }} 
                                <span class="text-gray-400 font-normal">({{ $activity->asset->asset_code ?? '-' }})</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $activity->notes }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs font-medium text-gray-500 block">{{ $activity->created_at->diffForHumans() }}</span>
                            <span class="text-[10px] text-gray-400">Oleh: {{ $activity->user->name ?? 'Sistem' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-6">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>