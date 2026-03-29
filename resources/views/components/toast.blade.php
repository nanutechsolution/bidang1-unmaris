<div
    x-data="toastNotifier()"
    x-on:notify.window="add($event.detail)"
    class="fixed top-6 right-6 z-[99] flex flex-col gap-3 w-full max-w-sm pointer-events-none"
>
    @if(session()->has('success'))
        <div x-init="$nextTick(() => add({ type: 'success', message: '{{ session('success') }}' }))"></div>
    @endif
    @if(session()->has('error'))
        <div x-init="$nextTick(() => add({ type: 'error', message: '{{ session('error') }}' }))"></div>
    @endif

    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0 scale-90"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-90"
            class="pointer-events-auto flex items-start p-4 bg-white/95 backdrop-blur-md border border-gray-100 shadow-2xl rounded-2xl ring-1 ring-black/5 overflow-hidden relative"
        >
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                 :class="{
                     'bg-green-500': toast.type === 'success',
                     'bg-red-500': toast.type === 'error',
                     'bg-blue-500': toast.type === 'info',
                 }">
            </div>

            <div class="flex-shrink-0 ml-2 mr-3 mt-0.5">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </template>
            </div>

            <div class="flex-1 pr-2">
                <h3 class="text-sm font-semibold text-gray-900" x-text="toast.type === 'success' ? 'Berhasil' : (toast.type === 'error' ? 'Terjadi Kesalahan' : 'Informasi')"></h3>
                <p class="mt-1 text-sm text-gray-500" x-text="toast.message"></p>
            </div>

            <button @click="remove(toast.id)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('toastNotifier', () => ({
        toasts: [],
        add(notice) {
            const id = Date.now();
            const toast = {
                id,
                type: notice.type || 'info',
                message: notice.message,
                visible: true
            };
            this.toasts.push(toast);
            
            // Auto-hide setelah 4 detik
            setTimeout(() => {
                this.remove(id);
            }, 4000);
        },
        remove(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) {
                toast.visible = false;
                // Tunggu transisi animasi selesai sebelum menghapus DOM
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300); 
            }
        }
    }));
});
</script>