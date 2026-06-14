<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Manajemen Kriteria & Perhitungan AHP</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Kriteria & AHP
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        

        <div class="row">
            <!-- Left: List Kriteria & Bobot -->
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kriteria</h5>
                        <form action="{{ route('admin.kriteria.recalculate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="ph-duotone ph-arrow-counter-clockwise"></i> Hitung Ulang
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th class="text-end">Bobot AHP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kriterias as $k)
                                        <tr class="align-middle">
                                            <td><span class="badge bg-light-primary text-primary fw-bold">{{ $k->kode }}</span></td>
                                            <td>
                                                <strong class="d-block">{{ $k->nama }}</strong>
                                                <small class="text-muted">{{ $k->subKriterias->count() }} Sub-kriteria</small>
                                            </td>
                                            <td class="text-end fw-bold text-success fs-6">
                                                {{ number_format(($k->bobot ?? 0) * 100, 2) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Consistency Status Info -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ringkasan Konsistensi (CR)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <span>Kriteria Utama:</span>
                            @if($ahpSummary['criteria']['is_consistent'])
                                <span class="badge bg-light-success text-success fw-bold">KONSISTEN (CR: {{ $ahpSummary['criteria']['cr'] }})</span>
                            @else
                                <span class="badge bg-light-danger text-danger fw-bold">TIDAK KONSISTEN (CR: {{ $ahpSummary['criteria']['cr'] }})</span>
                            @endif
                        </div>
                        <hr>
                        <h6 class="mb-2">Konsistensi Sub-kriteria:</h6>
                        @foreach($kriterias as $k)
                            @if(isset($ahpSummary['sub_criteria'][$k->kode]))
                                @php $subSum = $ahpSummary['sub_criteria'][$k->kode]; @endphp
                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <span class="text-muted">{{ $k->nama }} ({{ $k->kode }}):</span>
                                    @if($subSum['is_consistent'])
                                        <span class="badge bg-light-success text-success fw-bold">KONSISTEN (CR: {{ $subSum['cr'] }})</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger fw-bold">REVISI (CR: {{ $subSum['cr'] }})</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <div class="alert alert-warning mt-3 mb-0 py-2 text-sm" role="alert">
                            <small><i class="ph-duotone ph-warning-circle me-1"></i> Nilai Consistency Ratio (CR) harus &le; 0.10 agar dianggap konsisten dan valid.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Matrix Editors -->
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs card-header-tabs" id="ahpTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="criteria-tab" data-bs-toggle="tab" data-bs-target="#criteria-pane" type="button" role="tab" aria-controls="criteria-pane" aria-selected="true">
                                    <i class="ph-duotone ph-list-numbers me-1"></i> Perbandingan Kriteria
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="subcriteria-tab" data-bs-toggle="tab" data-bs-target="#subcriteria-pane" type="button" role="tab" aria-controls="subcriteria-pane" aria-selected="false">
                                    <i class="ph-duotone ph-grid-nine me-1"></i> Perbandingan Sub-Kriteria
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="ahpTabContent">
                            
                            <!-- TAB PANE 1: CRITERIA COMPARISON -->
                            <div class="tab-pane fade show active" id="criteria-pane" role="tabpanel" aria-labelledby="criteria-tab">
                                <h6 class="mb-3 text-primary">Matriks Perbandingan Berpasangan Kriteria</h6>
                                <p class="text-muted text-sm">
                                    Masukkan nilai tingkat kepentingan kriteria pada baris dibanding kriteria pada kolom. 
                                    (1 = Sama penting, 3 = Sedikit lebih penting, 5 = Lebih penting, 7 = Sangat lebih penting, 9 = Mutlak lebih penting. Nilai pecahan 0.5, 0.33, dll. otomatis terisi untuk nilai kebalikannya).
                                </p>
                                
                                <form action="{{ route('admin.kriteria.update-comparison') }}" method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="width: 15%">Kriteria</th>
                                                    @foreach($kriterias as $kCol)
                                                        <th>{{ $kCol->nama }} ({{ $kCol->kode }})</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($kriterias as $i => $kRow)
                                                    <tr>
                                                        <td class="fw-bold table-light">{{ $kRow->nama }}</td>
                                                        @foreach($kriterias as $j => $kCol)
                                                            <td>
                                                                @if($i === $j)
                                                                    <span class="fw-bold text-muted">1</span>
                                                                @elseif($i < $j)
                                                                    <!-- Editable Input above diagonal -->
                                                                    @php 
                                                                        $currentVal = $criteriaComparisons[$kRow->id][$kCol->id] ?? 1.0; 
                                                                    @endphp
                                                                    <select name="comparison[{{ $kRow->id }}][{{ $kCol->id }}]" class="form-select form-select-sm mx-auto" style="min-width: 90px;">
                                                                        <option value="1" {{ $currentVal == 1 ? 'selected' : '' }}>1 (Sama)</option>
                                                                        <option value="2" {{ $currentVal == 2 ? 'selected' : '' }}>2</option>
                                                                        <option value="3" {{ $currentVal == 3 ? 'selected' : '' }}>3 (Sedikit penting)</option>
                                                                        <option value="4" {{ $currentVal == 4 ? 'selected' : '' }}>4</option>
                                                                        <option value="5" {{ $currentVal == 5 ? 'selected' : '' }}>5 (Lebih penting)</option>
                                                                        <option value="6" {{ $currentVal == 6 ? 'selected' : '' }}>6</option>
                                                                        <option value="7" {{ $currentVal == 7 ? 'selected' : '' }}>7 (Sangat penting)</option>
                                                                        <option value="8" {{ $currentVal == 8 ? 'selected' : '' }}>8</option>
                                                                        <option value="9" {{ $currentVal == 9 ? 'selected' : '' }}>9 (Mutlak penting)</option>
                                                                        
                                                                        <!-- Reciprocals -->
                                                                        <option value="0.5" {{ abs($currentVal - 0.5) < 0.01 ? 'selected' : '' }}>1/2</option>
                                                                        <option value="0.3333" {{ abs($currentVal - 0.3333) < 0.01 ? 'selected' : '' }}>1/3</option>
                                                                        <option value="0.25" {{ abs($currentVal - 0.25) < 0.01 ? 'selected' : '' }}>1/4</option>
                                                                        <option value="0.2" {{ abs($currentVal - 0.2) < 0.01 ? 'selected' : '' }}>1/5</option>
                                                                        <option value="0.1667" {{ abs($currentVal - 0.1667) < 0.01 ? 'selected' : '' }}>1/6</option>
                                                                        <option value="0.1429" {{ abs($currentVal - 0.1429) < 0.01 ? 'selected' : '' }}>1/7</option>
                                                                        <option value="0.125" {{ abs($currentVal - 0.125) < 0.01 ? 'selected' : '' }}>1/8</option>
                                                                        <option value="0.1111" {{ abs($currentVal - 0.1111) < 0.01 ? 'selected' : '' }}>1/9</option>
                                                                    </select>
                                                                @else
                                                                    <!-- Readonly Reciprocal below diagonal -->
                                                                    @php 
                                                                        $recipVal = $criteriaComparisons[$kRow->id][$kCol->id] ?? 1.0; 
                                                                    @endphp
                                                                    <span class="text-sm font-monospace text-muted">
                                                                        @if($recipVal < 1)
                                                                            {{ round($recipVal, 4) }}
                                                                        @else
                                                                            {{ round($recipVal, 2) }}
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ph-duotone ph-floppy-disk"></i> Simpan Matriks Kriteria
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB PANE 2: SUB-CRITERIA COMPARISONS -->
                            <div class="tab-pane fade" id="subcriteria-pane" role="tabpanel" aria-labelledby="subcriteria-tab">
                                <h6 class="mb-3 text-primary">Matriks Perbandingan Berpasangan Sub-Kriteria</h6>
                                <p class="text-muted text-sm">
                                    Pilih kriteria terlebih dahulu untuk menampilkan dan mengedit matriks perbandingan sub-kriteria di bawahnya.
                                </p>

                                <!-- Inner Dropdown Select for Criteria -->
                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label fw-bold">Pilih Kriteria Utama:</label>
                                    <div class="col-sm-6">
                                        <select id="criteriaSelector" class="form-select">
                                            @foreach($kriterias as $kSel)
                                                <option value="sub-pane-{{ $kSel->kode }}">{{ $kSel->nama }} ({{ $kSel->kode }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Matrices for Sub-criteria (Shown dynamically using JS switcher) -->
                                @foreach($kriterias as $kRow)
                                    <div class="sub-matrix-pane d-none" id="sub-pane-{{ $kRow->kode }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-secondary mb-0">Perbandingan Sub-Kriteria: <strong>{{ $kRow->nama }} ({{ $kRow->kode }})</strong></h6>
                                            @if(isset($ahpSummary['sub_criteria'][$kRow->kode]))
                                                @php $subSum = $ahpSummary['sub_criteria'][$kRow->kode]; @endphp
                                                @if($subSum['is_consistent'])
                                                    <span class="badge bg-light-success text-success">KONSISTEN (CR: {{ $subSum['cr'] }})</span>
                                                @else
                                                    <span class="badge bg-light-danger text-danger">TIDAK KONSISTEN (CR: {{ $subSum['cr'] }})</span>
                                                @endif
                                            @endif
                                        </div>

                                        <form action="{{ route('admin.kriteria.update-sub-comparison') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="kriteria_id" value="{{ $kRow->id }}">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped text-center align-middle">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th style="width: 15%">Sub-Kriteria</th>
                                                            @foreach($kRow->subKriterias as $sCol)
                                                                <th>{{ $sCol->nama }} ({{ $sCol->kode }})</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($kRow->subKriterias as $i => $sRow)
                                                            <tr>
                                                                <td class="fw-bold table-light text-start">{{ $sRow->nama }}</td>
                                                                @foreach($kRow->subKriterias as $j => $sCol)
                                                                    <td>
                                                                        @if($i === $j)
                                                                            <span class="fw-bold text-muted">1</span>
                                                                        @elseif($i < $j)
                                                                            @php 
                                                                                $currentVal = $subComparisons[$kRow->id][$sRow->id][$sCol->id] ?? 1.0; 
                                                                            @endphp
                                                                            <select name="comparison[{{ $sRow->id }}][{{ $sCol->id }}]" class="form-select form-select-sm mx-auto" style="min-width: 90px;">
                                                                                <option value="1" {{ $currentVal == 1 ? 'selected' : '' }}>1 (Sama)</option>
                                                                                <option value="2" {{ $currentVal == 2 ? 'selected' : '' }}>2</option>
                                                                                <option value="3" {{ $currentVal == 3 ? 'selected' : '' }}>3 (Sedikit penting)</option>
                                                                                <option value="4" {{ $currentVal == 4 ? 'selected' : '' }}>4</option>
                                                                                <option value="5" {{ $currentVal == 5 ? 'selected' : '' }}>5 (Lebih penting)</option>
                                                                                <option value="6" {{ $currentVal == 6 ? 'selected' : '' }}>6</option>
                                                                                <option value="7" {{ $currentVal == 7 ? 'selected' : '' }}>7 (Sangat penting)</option>
                                                                                <option value="8" {{ $currentVal == 8 ? 'selected' : '' }}>8</option>
                                                                                <option value="9" {{ $currentVal == 9 ? 'selected' : '' }}>9 (Mutlak penting)</option>
                                                                                
                                                                                <!-- Reciprocals -->
                                                                                <option value="0.5" {{ abs($currentVal - 0.5) < 0.01 ? 'selected' : '' }}>1/2</option>
                                                                                <option value="0.3333" {{ abs($currentVal - 0.3333) < 0.01 ? 'selected' : '' }}>1/3</option>
                                                                                <option value="0.25" {{ abs($currentVal - 0.25) < 0.01 ? 'selected' : '' }}>1/4</option>
                                                                                <option value="0.2" {{ abs($currentVal - 0.2) < 0.01 ? 'selected' : '' }}>1/5</option>
                                                                                <option value="0.1667" {{ abs($currentVal - 0.1667) < 0.01 ? 'selected' : '' }}>1/6</option>
                                                                                <option value="0.1429" {{ abs($currentVal - 0.1429) < 0.01 ? 'selected' : '' }}>1/7</option>
                                                                                <option value="0.125" {{ abs($currentVal - 0.125) < 0.01 ? 'selected' : '' }}>1/8</option>
                                                                                <option value="0.1111" {{ abs($currentVal - 0.1111) < 0.01 ? 'selected' : '' }}>1/9</option>
                                                                            </select>
                                                                        @else
                                                                            @php 
                                                                                $recipVal = $subComparisons[$kRow->id][$sRow->id][$sCol->id] ?? 1.0; 
                                                                            @endphp
                                                                            <span class="text-sm font-monospace text-muted">
                                                                                @if($recipVal < 1)
                                                                                    {{ round($recipVal, 4) }}
                                                                                @else
                                                                                    {{ round($recipVal, 2) }}
                                                                                @endif
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="sub-weights-preview">
                                                    <strong>Bobot Saat Ini:</strong>
                                                    @foreach($kRow->subKriterias as $sWeight)
                                                        <span class="badge bg-light-secondary text-dark ms-1">
                                                            {{ $sWeight->nama }}: {{ number_format(($sWeight->bobot ?? 0) * 100, 2) }}%
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="ph-duotone ph-floppy-disk"></i> Simpan Matriks Sub-Kriteria
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selector = document.getElementById("criteriaSelector");
            
            function showSelectedPane() {
                var selectedValue = selector.value;
                // Hide all sub matrix panes
                document.querySelectorAll(".sub-matrix-pane").forEach(function(pane) {
                    pane.classList.add("d-none");
                });
                // Show selected pane
                var selectedPane = document.getElementById(selectedValue);
                if (selectedPane) {
                    selectedPane.classList.remove("d-none");
                }
            }

            selector.addEventListener("change", showSelectedPane);
            showSelectedPane(); // Run once on load
        });
    </script>
    @endpush
</x-app>
