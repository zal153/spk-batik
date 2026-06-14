<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Rekomendasi Batik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Customer</a>
                <svg class="w-3 h-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('customer.riwayat') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Riwayat</a>
                <svg class="w-3 h-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-800 dark:text-gray-200 font-medium">Hasil Rekomendasi</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Selected Preferences Info -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white rounded-2xl p-6 shadow-xl relative overflow-hidden h-fit">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-30"></div>
                        
                        <div class="relative space-y-5">
                            <div class="border-b border-white/20 pb-4">
                                <h3 class="font-bold text-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Preferensi Anda
                                </h3>
                                <p class="text-xs text-indigo-100 mt-1">Kombinasi kriteria pilihan kuesioner Anda.</p>
                            </div>

                            <div class="space-y-4">
                                @foreach($riwayat->preferences as $cKode => $subId)
                                    @php 
                                        $kriteria = \App\Models\Kriteria::where('kode', $cKode)->first();
                                        $sub = \App\Models\SubKriteria::find($subId);
                                    @endphp
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-semibold text-indigo-200 uppercase tracking-wider">{{ $cKode }} - {{ $kriteria->nama ?? '' }}</span>
                                        <span class="font-bold text-lg mt-0.5">{{ $sub->nama ?? '-' }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-white/20 pt-4 mt-2">
                                <a href="{{ route('customer.rekomendasi') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-yellow-400 hover:bg-yellow-500 active:scale-[0.98] text-gray-900 font-bold text-sm rounded-xl shadow-lg transition duration-150">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                    </svg>
                                    Cari Ulang / Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: AHP Ranking Results -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-700 pb-4 mb-4 gap-2">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0V9.75A3.75 3.75 0 0 0 10.5 6a3.75 3.75 0 0 0-3.75 3.75v5.625c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.75a9 9 0 0 0-9-9" />
                                    </svg>
                                    Peringkat Batik
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar produk diurutkan berdasarkan persentase kecocokan paling tinggi.</p>
                            </div>
                            <span class="text-xs font-mono text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1 rounded-md self-start sm:self-auto">
                                {{ $riwayat->created_at->format('d M Y H:i') }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            @foreach($riwayat->results as $index => $item)
                                @php 
                                    $rank = $index + 1;
                                    $isFirst = $rank === 1;
                                    
                                    // Dynamic styling based on rank
                                    $cardBorder = $isFirst 
                                        ? 'border-indigo-600 dark:border-indigo-500 shadow-md ring-2 ring-indigo-500/10' 
                                        : 'border-gray-200 dark:border-gray-700';
                                    
                                    $rankBg = $rank === 1 
                                        ? 'bg-indigo-600 dark:bg-indigo-500 text-white' 
                                        : ($rank === 2 
                                            ? 'bg-emerald-600 dark:bg-emerald-500 text-white' 
                                            : ($rank === 3 
                                                ? 'bg-amber-500 dark:bg-amber-400 text-gray-900' 
                                                : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300'));
                                @endphp

                                <div class="rounded-xl border {{ $cardBorder }} p-4 bg-white dark:bg-gray-800 transition-all duration-300 hover:shadow-md {{ $index >= 5 ? 'more-suggestions hidden' : '' }}">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                        
                                        <!-- Rank Badge -->
                                        <div class="flex-shrink-0 flex items-center justify-center">
                                            <span class="w-10 h-10 rounded-full font-bold text-sm flex items-center justify-center {{ $rankBg }} shadow-sm">
                                                #{{ $rank }}
                                            </span>
                                        </div>

                                        <!-- Product Image -->
                                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                            @if($item['gambar'])
                                                <img src="{{ asset('storage/' . $item['gambar']) }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v14.25a1.5 1.5 0 0 0 1.5 1.5Z" />
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-[10px] font-mono font-semibold px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                                    {{ $item['kode'] }}
                                                </span>
                                                <h4 class="font-bold text-gray-900 dark:text-white truncate text-base">
                                                    {{ $item['nama'] }}
                                                </h4>
                                            </div>
                                            <p class="text-indigo-600 dark:text-indigo-400 font-extrabold mt-1 text-sm">
                                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                            </p>
                                            
                                            <!-- Specifications list -->
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-600">Bahan: {{ $item['spesifikasi']['bahan'] }}</span>
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-600">Motif: {{ $item['spesifikasi']['motif'] }}</span>
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-600">Warna: {{ $item['spesifikasi']['warna'] }}</span>
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-600">Fungsi: {{ $item['spesifikasi']['fungsi'] }}</span>
                                            </div>
                                            
                                            @if(isset($item['keterangan']))
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 line-clamp-1">
                                                    {{ $item['keterangan'] }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Match Score Gauge -->
                                        <div class="flex-shrink-0 text-center sm:text-right border-t sm:border-t-0 sm:border-l border-gray-100 dark:border-gray-700 pt-3 sm:pt-0 sm:pl-4 self-stretch flex sm:flex-col justify-between sm:justify-center items-center sm:items-end gap-2">
                                            <div>
                                                <span class="block text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kecocokan</span>
                                                <span class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">
                                                    {{ $item['kecocokan'] }}%
                                                </span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-mono">
                                                Selisih: {{ $item['total_selisih'] }}
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if(count($riwayat->results) > 5)
                            <div class="text-center mt-6" id="more-suggestions-btn-container">
                                <button type="button" id="show-more-btn" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-lg transition duration-150">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                    Tampilkan Saran Lainnya
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var showMoreBtn = document.getElementById("show-more-btn");
            var btnContainer = document.getElementById("more-suggestions-btn-container");
            
            if (showMoreBtn) {
                showMoreBtn.addEventListener("click", function() {
                    document.querySelectorAll(".more-suggestions").forEach(function(el) {
                        el.classList.remove("hidden");
                    });
                    if (btnContainer) {
                        btnContainer.classList.add("hidden");
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
