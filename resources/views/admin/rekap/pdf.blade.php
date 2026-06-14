<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Pencarian Customer</title>
    <style>
        @page {
            margin: 40px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
            background: #ffffff;
        }
        .letterhead {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4f46e5;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: 0.5px;
        }
        .system-name {
            font-size: 12px;
            font-weight: bold;
            color: #4b5563;
            margin-top: 2px;
        }
        .company-address {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }
        .report-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
            margin: 20px 0 15px 0;
            text-transform: uppercase;
        }
        .summary-box {
            background: #f3f4f6;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-left: 4px solid #4f46e5;
        }
        .summary-item {
            font-size: 11px;
            margin-bottom: 3px;
            color: #4b5563;
        }
        .summary-item:last-child {
            margin-bottom: 0;
        }
        .summary-label {
            font-weight: bold;
            color: #1f2937;
            display: inline-block;
            width: 100px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #ffffff;
        }
        .report-table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            padding: 8px 10px;
            border: 1px solid #4f46e5;
            text-align: left;
        }
        .report-table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 10px;
            color: #374151;
        }
        .report-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .customer-name {
            font-weight: bold;
            color: #111827;
        }
        .customer-email {
            font-size: 9px;
            color: #6b7280;
            margin-top: 1px;
        }
        .preference-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .preference-list li {
            margin-bottom: 4px;
            font-size: 9.5px;
        }
        .pref-label {
            font-weight: bold;
            color: #4f46e5;
            margin-right: 3px;
        }
        .result-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .result-list li {
            margin-bottom: 4px;
            font-size: 9.5px;
        }
        .rank-label {
            font-weight: bold;
            color: #4b5563;
            margin-right: 3px;
        }
        .rank-1 .rank-label {
            color: #b45309; /* Amber for Rank 1 */
        }
        .match-pct {
            font-weight: bold;
            color: #16a34a;
            float: right;
        }
    </style>
</head>
<body>
    @php
        $indonesian_months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $today = now();
        $tanggal_cetak = $today->format('d') . ' ' . $indonesian_months[(int)$today->format('m')] . ' ' . $today->format('Y');
    @endphp

    <div class="letterhead">
        <div class="company-name">TOKO APOLLO</div>
        <div class="system-name">Sistem Pendukung Keputusan Pemilihan Batik (Metode AHP)</div>
        <div class="company-address">Jl. Apollo No. 123, Pamekasan, Jawa Timur</div>
    </div>

    <div class="report-title">Laporan Rekap Pencarian Customer</div>

    <div class="summary-box">
        <div class="summary-item">
            <span class="summary-label">Tanggal Cetak</span>: {{ $tanggal_cetak }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Riwayat</span>: {{ count($riwayats) }} data pencarian
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 23%;">Customer</th>
                <th style="width: 27%;">Preferensi Pilihan</th>
                <th style="width: 30%;">Rekomendasi Teratas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $index => $riwayat)
                @php
                    $tgl = $riwayat->created_at;
                    $formatted_date = $tgl->format('d') . ' ' . $indonesian_months[(int)$tgl->format('m')] . ' ' . $tgl->format('Y');
                @endphp
                <tr>
                    <td class="text-center" style="font-weight: bold;">{{ $index + 1 }}</td>
                    <td>{{ $formatted_date }}</td>
                    <td>
                        <div class="customer-name">{{ $riwayat->user->name ?? 'Guest / Anonim' }}</div>
                        @if($riwayat->user)
                            <div class="customer-email">{{ $riwayat->user->email }}</div>
                        @endif
                    </td>
                    <td>
                        <ul class="preference-list">
                            @foreach($riwayat->preferences as $cKode => $subId)
                                @php $sub = \App\Models\SubKriteria::find($subId); @endphp
                                @if($sub)
                                    <li>
                                        <span class="pref-label">[{{ $cKode }}]</span>
                                        <span>{{ $sub->nama }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="result-list">
                            @php $top = array_slice($riwayat->results, 0, 3); @endphp
                            @foreach($top as $rank => $item)
                                <li class="rank-{{ $rank + 1 }}">
                                    <span class="rank-label">#{{ $rank + 1 }}</span>
                                    <span>{{ $item['nama'] }}</span>
                                    <span class="match-pct">{{ $item['kecocokan'] }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
