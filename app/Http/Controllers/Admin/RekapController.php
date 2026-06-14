<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatRekomendasi;

class RekapController extends Controller
{
    public function index()
    {
        // Load recommendation histories from database with User relations
        $riwayats = RiwayatRekomendasi::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.rekap.index', compact('riwayats'));
    }

    public function exportPdf()
    {
        $riwayats = RiwayatRekomendasi::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.rekap.pdf', compact('riwayats'));
        return $pdf->download('laporan-rekap-pencarian.pdf');
    }

    public function destroy(RiwayatRekomendasi $riwayat)
    {
        $riwayat->delete();

        return redirect()->route('admin.rekap.index')->with('success', 'Riwayat rekomendasi berhasil dihapus dari rekap!');
    }
}
