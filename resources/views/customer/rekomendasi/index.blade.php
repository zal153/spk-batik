<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cari Rekomendasi Batik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Customer</a>
                <svg class="w-3 h-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-800 dark:text-gray-200 font-medium">Cari Rekomendasi</span>
            </div>

            <!-- Questionnaire Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6 sm:px-8 sm:py-8 text-center text-white relative">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-30"></div>
                    <div class="relative">
                        <h3 class="text-xl sm:text-2xl font-bold mb-2">Toko Apollo</h3>
                        <p class="text-indigo-100 text-sm max-w-xl mx-auto leading-relaxed">
                            Pilih preferensi kriteria Anda pada formulir di bawah ini. Sistem AHP akan menghitung kecocokan dan memberikan saran produk batik terbaik.
                        </p>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-r-xl">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-300">Terjadi kesalahan input:</h3>
                                    <ul class="mt-1 list-disc list-inside text-sm text-red-700 dark:text-red-400">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('customer.rekomendasi.proses') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Column 1: C1 - Bahan Batik -->
                            <div>
                                <label for="pref-C1" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">C1 - Bahan Batik</label>
                                <select name="preferensi[C1]" id="pref-C1" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" required>
                                    <option value="" disabled selected>Pilih Bahan...</option>
                                    @foreach($kriterias->where('kode', 'C1')->first()->subKriterias as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Column 2: C2 - Motif Batik -->
                            <div>
                                <label for="pref-C2" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">C2 - Motif Batik</label>
                                <select name="preferensi[C2]" id="pref-C2" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" required>
                                    <option value="" disabled selected>Pilih Motif...</option>
                                    @foreach($kriterias->where('kode', 'C2')->first()->subKriterias as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Column 3: C3 - Anggaran Harga -->
                            <div>
                                <label for="pref-C3" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">C3 - Anggaran Harga</label>
                                <select name="preferensi[C3]" id="pref-C3" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" required>
                                    <option value="" disabled selected>Pilih Harga...</option>
                                    @foreach($kriterias->where('kode', 'C3')->first()->subKriterias as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Column 4: C4 - Warna Batik -->
                            <div>
                                <label for="pref-C4" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">C4 - Warna Batik</label>
                                <select name="preferensi[C4]" id="pref-C4" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" required>
                                    <option value="" disabled selected>Pilih Warna...</option>
                                    @foreach($kriterias->where('kode', 'C4')->first()->subKriterias as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Column 5: C5 - Fungsi Penggunaan -->
                            <div>
                                <label for="pref-C5" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">C5 - Fungsi Penggunaan</label>
                                <select name="preferensi[C5]" id="pref-C5" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm" required>
                                    <option value="" disabled selected>Pilih Fungsi...</option>
                                    @foreach($kriterias->where('kode', 'C5')->first()->subKriterias as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Column 6: Submit Button -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-lg transition duration-150 uppercase tracking-wide h-[42px] mb-0.5">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                    Cari Rekomendasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
