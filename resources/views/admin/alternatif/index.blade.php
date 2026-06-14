<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Katalog Alternatif Batik</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Katalog Batik
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        

        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Katalog Batik (Alternatif)</h5>
                <a href="{{ route('admin.alternatif.create') }}" class="btn btn-primary">
                    <i class="ph-duotone ph-plus-circle"></i> Tambah Batik Baru
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 align-middle" id="alternatif-table">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Gambar</th>
                                <th style="width: 10%">Kode</th>
                                <th style="width: 20%">Nama Batik</th>
                                <th style="width: 15%">Harga</th>
                                <th style="width: 30%">Spesifikasi Kriteria</th>
                                <th style="width: 10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alternatifs as $index => $alt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($alt->gambar)
                                            <img src="{{ asset('storage/' . $alt->gambar) }}" alt="{{ $alt->nama }}" class="img-thumbnail" style="max-height: 60px; max-width: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 60px;">
                                                <i class="ph-duotone ph-image fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-light-secondary text-dark fw-bold">{{ $alt->kode }}</span></td>
                                    <td>
                                        <strong>{{ $alt->nama }}</strong>
                                        @if($alt->keterangan)
                                            <p class="text-muted text-sm mb-0 text-truncate" style="max-width: 250px;" title="{{ $alt->keterangan }}">
                                                {{ $alt->keterangan }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-primary">
                                        Rp {{ number_format($alt->harga, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-light-info text-info text-xs" title="Bahan">
                                                <i class="ph-duotone ph-shield-checkered"></i> {{ $alt->bahan->nama ?? '-' }}
                                            </span>
                                            <span class="badge bg-light-warning text-warning text-xs" title="Motif">
                                                <i class="ph-duotone ph-paint-brush-broad"></i> {{ $alt->motif->nama ?? '-' }}
                                            </span>
                                            <span class="badge bg-light-success text-success text-xs" title="Harga Kriteria">
                                                <i class="ph-duotone ph-tag"></i> {{ $alt->hargaSub->nama ?? '-' }}
                                            </span>
                                            <span class="badge bg-light-danger text-danger text-xs" title="Warna">
                                                <i class="ph-duotone ph-palette"></i> {{ $alt->warna->nama ?? '-' }}
                                            </span>
                                            <span class="badge bg-light-dark text-dark text-xs" title="Fungsi">
                                                <i class="ph-duotone ph-users"></i> {{ $alt->fungsi->nama ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.alternatif.edit', $alt->id) }}" class="btn btn-outline-success" title="Edit">
                                                <i class="ph-duotone ph-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="confirmDelete('delete-form-{{ $alt->id }}', 'Hapus batik ini dari katalog?')">
                                                <i class="ph-duotone ph-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $alt->id }}" action="{{ route('admin.alternatif.destroy', $alt->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data batik di katalog.</td>
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
                const dataTable = new simpleDatatables.DataTable("#alternatif-table", {
                    searchable: true,
                    fixedHeight: false,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari batik...",
                        perPage: "entri per halaman",
                        noRows: "Tidak ada data batik ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} entri",
                    }
                });
            });
        </script>
    @endpush
</x-app>
