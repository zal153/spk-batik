<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Customer') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Hero Banner --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 sm:p-10 shadow-xl">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>
                <div class="relative flex flex-col sm:flex-row items-center gap-6">
                    <div class="flex-1">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-indigo-100 text-sm sm:text-base mb-5 max-w-xl leading-relaxed">
                            Temukan batik terbaik dengan Sistem Pendukung Keputusan kami menggunakan metode <strong class="text-white">AHP (Analytic Hierarchy Process)</strong>.
                            Pilih preferensi Anda dan dapatkan rekomendasi batik yang paling sesuai!
                        </p>
                        <a href="{{ route('customer.rekomendasi') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-700 font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Mulai Cari Rekomendasi
                        </a>
                    </div>
                    <div class="hidden sm:flex items-center justify-center">
                        <svg class="w-32 h-32 text-white/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Katalog Batik Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $katalogCount }} <span class="text-sm font-normal text-gray-500">produk</span></p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pencarian Anda</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $riwayatCount }} <span class="text-sm font-normal text-gray-500">kali</span></p>
                    </div>
                </div>
            </div>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Recent Searches --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Pencarian Terakhir</h3>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($riwayats as $riwayat)
                                <a href="{{ route('customer.riwayat.show', $riwayat->id) }}"
                                   class="block px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0">
                                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $riwayat->created_at->format('d M Y H:i') }}</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">Rekomendasi #{{ $riwayat->id }}</p>
                                        </div>
                                        <span class="flex-shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">
                                            {{ $riwayat->results[0]['nama'] ?? '-' }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="px-5 py-8 text-center">
                                    <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat pencarian.</p>
                                    <a href="{{ route('customer.rekomendasi') }}" class="mt-2 inline-block text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Mulai pencarian pertama →
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Product Spotlight --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Sorotan Produk Batik Apollo</h3>
                            <a href="{{ route('customer.rekomendasi') }}" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                Cari Kecocokan →
                            </a>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($topBatik as $batik)
                                    <div class="group rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                        @if($batik->gambar)
                                            <div class="h-44 overflow-hidden">
                                                <img src="{{ asset('storage/' . $batik->gambar) }}"
                                                     alt="{{ $batik->nama }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        @else
                                            <div class="h-44 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v14.25a1.5 1.5 0 0 0 1.5 1.5Z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <div class="flex items-start justify-between mb-1">
                                                <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">{{ $batik->kode }}</span>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mt-1.5">{{ $batik->nama }}</h4>
                                            <p class="text-indigo-600 dark:text-indigo-400 font-bold text-sm mt-1">Rp {{ number_format($batik->harga, 0, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $batik->keterangan ?? 'Tidak ada deskripsi.' }}</p>
                                            <div class="flex flex-wrap gap-1 mt-3">
                                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">{{ $batik->bahan->nama ?? '-' }}</span>
                                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300">{{ $batik->motif->nama ?? '-' }}</span>
                                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300">{{ $batik->warna->nama ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
