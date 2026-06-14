<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Manajemen Akun Pengguna</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Manajemen Akun
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        

        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Akun Pengguna</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="ph-duotone ph-user-plus"></i> Tambah Akun Baru
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 align-middle" id="users-table">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 30%">Nama Lengkap</th>
                                <th style="width: 30%">Alamat Email</th>
                                <th style="width: 15%">Peran (Role)</th>
                                <th style="width: 10%">Tanggal Dibuat</th>
                                <th style="width: 10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td class="font-monospace">{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-light-danger text-danger fw-bold">Admin</span>
                                        @else
                                            <span class="badge bg-light-primary text-primary fw-bold">Customer</span>
                                        @endif
                                    </td>
                                    <td class="text-muted text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-success" title="Edit Akun">
                                                <i class="ph-duotone ph-pencil"></i>
                                            </a>
                                            @if($user->email !== 'admin@batik.com')
                                                <button type="button" class="btn btn-outline-danger" title="Hapus Akun" onclick="confirmDelete('delete-user-{{ $user->id }}', 'Hapus akun ini?')">
                                                    <i class="ph-duotone ph-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                        @if($user->email !== 'admin@batik.com')
                                            <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const dataTable = new simpleDatatables.DataTable("#users-table", {
                    searchable: true,
                    fixedHeight: false,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari pengguna...",
                        perPage: "entri per halaman",
                        noRows: "Tidak ada data pengguna ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} entri",
                    }
                });
            });
        </script>
    @endpush
</x-app>
