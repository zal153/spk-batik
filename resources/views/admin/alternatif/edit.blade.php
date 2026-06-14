<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Edit Detail Batik</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.alternatif.index') }}">Katalog Batik</a>
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
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Form Edit Alternatif Batik: <strong>{{ $alternatif->nama }}</strong></h5>
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

                        <form action="{{ route('admin.alternatif.update', $alternatif->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="kode" class="form-label fw-bold">Kode Alternatif</label>
                                    <input type="text" name="kode" id="kode" class="form-control" placeholder="Contoh: B020" value="{{ old('kode', $alternatif->kode) }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="nama" class="form-label fw-bold">Nama Batik</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Batik Mega Mendung" value="{{ old('nama', $alternatif->nama) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label fw-bold">Harga Real (Rupiah)</label>
                                    <input type="number" name="harga" id="harga" class="form-control" placeholder="Contoh: 250000" value="{{ old('harga', $alternatif->harga) }}" required>
                                    <small class="text-muted">Kategori Kriteria Harga akan otomatis disesuaikan berdasarkan range harga.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="gambar" class="form-label fw-bold">Gambar Produk</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                    @if($alternatif->gambar)
                                        <div class="mt-2">
                                            <span class="text-xs text-muted d-block">Gambar Saat Ini:</span>
                                            <img src="{{ asset('storage/' . $alternatif->gambar) }}" alt="{{ $alternatif->nama }}" class="img-thumbnail" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label fw-bold">Keterangan / Deskripsi</label>
                                <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Tuliskan keterangan detail mengenai batik ini...">{{ old('keterangan', $alternatif->keterangan) }}</textarea>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Spesifikasi Kriteria AHP</h6>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bahan_sub_id" class="form-label fw-bold">C1 - Bahan Batik</label>
                                    <select name="bahan_sub_id" id="bahan_sub_id" class="form-select" required>
                                        <option value="" disabled>Pilih Bahan...</option>
                                        @foreach($bahans as $sub)
                                            <option value="{{ $sub->id }}" {{ old('bahan_sub_id', $alternatif->bahan_sub_id) == $sub->id ? 'selected' : '' }}>{{ $sub->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="motif_sub_id" class="form-label fw-bold">C2 - Motif Batik</label>
                                    <select name="motif_sub_id" id="motif_sub_id" class="form-select" required>
                                        <option value="" disabled>Pilih Motif...</option>
                                        @foreach($motifs as $sub)
                                            <option value="{{ $sub->id }}" {{ old('motif_sub_id', $alternatif->motif_sub_id) == $sub->id ? 'selected' : '' }}>{{ $sub->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="warna_sub_id" class="form-label fw-bold">C4 - Warna Batik</label>
                                    <select name="warna_sub_id" id="warna_sub_id" class="form-select" required>
                                        <option value="" disabled>Pilih Warna...</option>
                                        @foreach($warnas as $sub)
                                            <option value="{{ $sub->id }}" {{ old('warna_sub_id', $alternatif->warna_sub_id) == $sub->id ? 'selected' : '' }}>{{ $sub->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fungsi_sub_id" class="form-label fw-bold">C5 - Fungsi Batik</label>
                                    <select name="fungsi_sub_id" id="fungsi_sub_id" class="form-select" required>
                                        <option value="" disabled>Pilih Fungsi...</option>
                                        @foreach($fungsis as $sub)
                                            <option value="{{ $sub->id }}" {{ old('fungsi_sub_id', $alternatif->fungsi_sub_id) == $sub->id ? 'selected' : '' }}>{{ $sub->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.alternatif.index') }}" class="btn btn-light-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-duotone ph-floppy-disk"></i> Update Batik
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
