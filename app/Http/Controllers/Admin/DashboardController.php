<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\RiwayatRekomendasi;
use App\Models\SubKriteria;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $kriteriaCount = Kriteria::count();
        $subKriteriaCount = SubKriteria::count();
        $alternatifCount = Alternatif::count();
        $riwayatCount = RiwayatRekomendasi::count();
        $userCount = User::count();

        // Get criteria weight chart data
        $kriterias = Kriteria::orderBy('kode', 'asc')->get();

        // Get top 5 batik materials by count
        $topBahan = Alternatif::select('bahan_sub_id')
            ->selectRaw('count(*) as total')
            ->groupBy('bahan_sub_id')
            ->with('bahan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'kriteriaCount',
            'subKriteriaCount',
            'alternatifCount',
            'riwayatCount',
            'userCount',
            'kriterias',
            'topBahan'
        ));
    }
}
