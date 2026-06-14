<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Edit Informasi Akun</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}">Manajemen Akun</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Edit
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Form Edit Akun: <strong>{{ $user->name }}</strong></h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Ika Nurjannah" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: user@email.com" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label fw-bold">Peran (Role)</label>
                                @if($user->email === 'admin@batik.com')
                                    <input type="hidden" name="role" value="admin">
                                    <select class="form-select" disabled>
                                        <option selected>Admin Toko (Utama)</option>
                                    </select>
                                @else
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer (Pembeli)</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin Toko</option>
                                    </select>
                                @endif
                            </div>

                            <div class="row mb-3 bg-light p-3 rounded">
                                <div class="col-12 mb-2">
                                    <span class="fw-bold d-block">Ubah Kata Sandi (Opsional)</span>
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah sandi.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">Sandi Baru</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Sandi</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-duotone ph-floppy-disk"></i> Update Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
