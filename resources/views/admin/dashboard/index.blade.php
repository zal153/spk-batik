<x-app>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center g-0">
                    <div class="col-sm-auto">
                        <div class="page-header-title">
                            <h5 class="mb-0">Dashboard Admin</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">Admin</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Dashboard
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- stats cards -->
            <div class="col-xl-12 col-md-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="card prod-p-card">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5">Total Kriteria</h6>
                                        <h3 class="m-b-0">{{ $kriteriaCount }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ph-duotone ph-list-numbers text-primary f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card prod-p-card bg-primary text-white">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">Sub-Kriteria</h6>
                                        <h3 class="m-b-0 text-white">{{ $subKriteriaCount }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ph-duotone ph-grid-nine text-white f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card prod-p-card">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5">Katalog Batik</h6>
                                        <h3 class="m-b-0">{{ $alternatifCount }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ph-duotone ph-t-shirt text-primary f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card prod-p-card bg-primary text-white">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">Laporan Rekap</h6>
                                        <h3 class="m-b-0 text-white">{{ $riwayatCount }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ph-duotone ph-file-text text-white f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 5 Materials Chart -->
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h5 class="mb-0"><i class="ph-duotone ph-chart-bar text-primary fs-4 me-2"></i>5 Jenis Bahan Batik dengan Stok Terbanyak</h5>
                        <a href="{{ route('admin.alternatif.index') }}" class="btn btn-sm btn-outline-primary">Kelola Katalog</a>
                    </div>
                    <div class="card-body">
                        <div id="batik-material-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>

    @push('scripts')
    <script src="{{ asset('') }}assets/js/plugins/apexcharts.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 6,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + " Batik";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                colors: ['#0d6efd'],
                series: [{
                    name: 'Jumlah Stok',
                    data: [
                        @foreach($topBahan as $item)
                            {{ $item->total }},
                        @endforeach
                    ]
                }],
                xaxis: {
                    categories: [
                        @foreach($topBahan as $item)
                            '{{ $item->bahan->nama ?? "Bahan" }}',
                        @endforeach
                    ],
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val + " pcs";
                        }
                    }
                },
                grid: {
                    padding: {
                        bottom: 15
                    }
                },
                title: {
                    text: 'Jumlah Produk Batik per Bahan (Top 5)',
                    floating: true,
                    offsetY: 345,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#batik-material-chart"), options);
            chart.render();
        });
    </script>
    @endpush
</x-app>