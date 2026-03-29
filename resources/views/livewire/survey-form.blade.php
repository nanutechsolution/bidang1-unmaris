<div class="max-w-xl mx-auto py-10 px-4 sm:px-0">
    
    @if($isSubmitted)
        <!-- Layar Sukses -->
        <div class="bg-white/90 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white p-10 text-center animate-fade-in">
            <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-unmaris-900 mb-2">Terima Kasih, {{ explode(' ', trim($name))[0] }}!</h2>
            <p class="text-gray-500 font-medium">Tanggapan Anda untuk survei "{{ $survey->title }}" telah berhasil direkam dalam sistem.</p>
        </div>
    @else
        <!-- Form Survei Dinamis -->
        <div class="bg-white/90 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white overflow-hidden relative">
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-sunmaris-400 to-sunmaris-500"></div>
            
            <div class="p-8 sm:p-10 pb-6 border-b border-gray-50">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-16 h-16 object-contain mb-4" />
                <h1 class="text-2xl font-extrabold text-unmaris-900 tracking-tight leading-tight">{{ $survey->title }}</h1>
                @if($survey->description)
                    <p class="text-sm text-gray-500 mt-2 font-medium">{{ $survey->description }}</p>
                @endif
            </div>

            <form wire:submit="submit" class="p-8 sm:p-10 space-y-8">
                
                <!-- Profil Responden (SSO SIAKAD) -->
                <div class="bg-unmaris-50/50 p-5 rounded-2xl border border-unmaris-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white text-unmaris-600 flex items-center justify-center font-extrabold text-lg shadow-sm border border-unmaris-100">
                        {{ substr($name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Terautentikasi SIAKAD
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $name ?? 'Nama Pengguna' }}</h3>
                        <p class="text-xs font-bold text-unmaris-600 uppercase mt-0.5">{{ $role ?? 'Status Pengguna' }}</p>
                    </div>
                </div>

                @error('submit')
                    <div class="p-4 bg-red-50 text-red-600 rounded-2xl text-sm font-bold border border-red-100">
                        {{ $message }}
                    </div>
                @enderror

                <!-- PERULANGAN PERTANYAAN DINAMIS -->
                <div class="space-y-6">
                    @foreach($survey->questions as $question)
                        <div class="bg-unmaris-50/30 p-6 rounded-3xl border border-unmaris-100/50 {{ $question->type === 'rating' ? 'text-center' : '' }}">
                            <label class="block text-sm font-bold text-unmaris-900 mb-4 leading-relaxed">
                                {{ $question->question_text }} 
                                @if($question->is_required) <span class="text-red-500">*</span> @endif
                            </label>

                            <!-- Jika Tipe Pertanyaan = Rating Bintang -->
                            @if($question->type === 'rating')
                                <div class="flex justify-center gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="setRating('{{ $question->id }}', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110 active:scale-95">
                                            <svg class="w-10 h-10 {{ (isset($answers[$question->id]) && $answers[$question->id] >= $i) ? 'text-sunmaris-500 drop-shadow-md' : 'text-gray-200' }} transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </button>
                                    @endfor
                                </div>
                            
                            <!-- Jika Tipe Pertanyaan = Input Teks -->
                            @elseif($question->type === 'text')
                                <textarea wire:model="answers.{{ $question->id }}" rows="3" class="block w-full px-5 py-4 bg-white border-0 text-gray-900 rounded-2xl ring-1 ring-inset ring-gray-100 focus:ring-2 focus:ring-inset focus:ring-unmaris-500 transition-all font-medium shadow-sm resize-none" placeholder="Tuliskan jawaban Anda di sini..."></textarea>
                            @endif

                            <!-- Pesan Error Dinamis -->
                            @error('answers.'.$question->id) 
                                <span class="text-red-500 text-[10px] mt-3 block font-bold {{ $question->type === 'rating' ? 'text-center' : '' }}">{{ $message }}</span> 
                            @enderror
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="w-full flex justify-center py-4 px-4 rounded-2xl shadow-[0_8px_20px_rgba(250,204,21,0.25)] text-sm font-extrabold text-unmaris-900 bg-gradient-to-r from-sunmaris-400 to-sunmaris-500 hover:from-sunmaris-300 hover:to-sunmaris-400 focus:outline-none transition-all hover:-translate-y-0.5 active:scale-95 mt-8">
                    <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-5 w-5 text-unmaris-900" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span wire:loading.remove wire:target="submit">Kirim Tanggapan</span>
                    <span wire:loading wire:target="submit">Menyimpan...</span>
                </button>
            </form>
        </div>
    @endif
</div>