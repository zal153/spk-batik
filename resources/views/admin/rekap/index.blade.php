<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Rekap Laporan Pencarian Customer</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Rekap Laporan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->



        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Log Riwayat Rekomendasi</h5>
                <a href="{{ route('admin.rekap.pdf') }}" class="btn btn-secondary btn-sm">
                    <i class="ph-duotone ph-file-pdf"></i> Ekspor PDF
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 align-middle" id="rekap-table">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Tanggal & Waktu</th>
                                <th style="width: 15%">Nama Customer</th>
                                <th style="width: 25%">Preferensi Pilihan</th>
                                <th style="width: 30%">Rekomendasi Terbaik (Top 3)</th>
                                <th style="width: 10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayats as $index => $riwayat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-monospace text-sm">{{ $riwayat->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td>
                                        @if ($riwayat->user)
                                            <strong>{{ $riwayat->user->name }}</strong>
                                            <span class="d-block text-muted text-xs">{{ $riwayat->user->email }}</span>
                                        @else
                                            <span class="text-muted italic">Guest / Anonim</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                            @foreach ($riwayat->preferences as $cKode => $subId)
                                                @php $sub = \App\Models\SubKriteria::find($subId); @endphp
                                                @if ($sub)
                                                    <span class="badge bg-light-secondary text-dark text-xs">
                                                        {{ $cKode }}: {{ $sub->nama }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Top 3 rankings -->
                                        @php $top = array_slice($riwayat->results, 0, 3); @endphp
                                        <div class="list-group list-group-flush py-1">
                                            @foreach ($top as $rank => $item)
                                                <div
                                                    class="d-flex justify-content-between align-items-center py-1 text-xs border-0">
                                                    <span>{{ $rank + 1 }}.
                                                        <strong>{{ $item['nama'] }}</strong></span>
                                                    <span
                                                        class="badge bg-light-success text-success fw-bold">{{ $item['kecocokan'] }}%
                                                        Match</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Log"
                                            onclick="confirmDelete('delete-riwayat-{{ $riwayat->id }}', 'Hapus log riwayat ini?')">
                                            <i class="ph-duotone ph-trash"></i> Hapus
                                        </button>
                                        <form id="delete-riwayat-{{ $riwayat->id }}"
                                            action="{{ route('admin.rekap.destroy', $riwayat->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pencarian
                                        kuesioner customer.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const dataTable = new simpleDatatables.DataTable("#rekap-table", {
                    searchable: true,
                    fixedHeight: false,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari riwayat/customer...",
                        perPage: "entri per halaman",
                        noRows: "Tidak ada data riwayat ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} entri",
                    }
                });
            });
        </script>
    @endpush
</x-app>
