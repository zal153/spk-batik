<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Rekomendasi Anda') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Log Riwayat Kuesioner</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar lengkap kuesioner preferensi batik yang pernah Anda cari beserta hasil rekomendasinya.</p>
                    </div>
                    <a href="{{ route('customer.rekomendasi') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white text-sm font-semibold rounded-xl shadow hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-150 self-start sm:self-auto">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Cari Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-4 w-12 text-center">No</th>
                                <th class="px-6 py-4 w-44">Tanggal & Waktu</th>
                                <th class="px-6 py-4">Preferensi Anda</th>
                                <th class="px-6 py-4">Hasil Rekomendasi Teratas</th>
                                <th class="px-6 py-4 w-32 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($riwayats as $index => $riwayat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 text-center">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap font-mono">
                                        {{ $riwayat->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1.5 max-w-md">
                                            @foreach($riwayat->preferences as $cKode => $subId)
                                                @php $sub = \App\Models\SubKriteria::find($subId); @endphp
                                                @if($sub)
                                                    <span class="inline-flex items-center text-xs px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-medium">
                                                        {{ $sub->nama }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        @php $top = $riwayat->results[0] ?? null; @endphp
                                        @if($top)
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                                    {{ $top['kecocokan'] }}% Cocok
                                                </span>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $top['nama'] }}</span>
                                                <span class="text-xs font-mono text-gray-400">({{ $top['kode'] }})</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('customer.riwayat.show', $riwayat->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 font-semibold rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition duration-150">
                                                <svg class="w-4 h-4 me-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                Detail
                                            </a>
                                            <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $riwayat->id }}', 'Hapus log riwayat pencarian ini?')"
                                                    class="inline-flex items-center p-1.5 bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-100 dark:hover:bg-rose-900/50 transition duration-150">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $riwayat->id }}" action="{{ route('customer.riwayat.destroy', $riwayat->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <p class="mt-4 text-sm font-semibold">Belum Ada Riwayat Rekomendasi</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Anda belum pernah melakukan pencarian preferensi kuesioner batik.</p>
                                        <a href="{{ route('customer.rekomendasi') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 dark:bg-indigo-500 text-white text-xs font-semibold rounded-xl shadow hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
                                            Mulai Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
