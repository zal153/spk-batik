<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\RiwayatRekomendasi;
use App\Services\AhpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function __construct(protected AhpService $ahpService) {}

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $katalogCount = Alternatif::count();
        // Get customer logs limit to the authenticated customer
        $riwayatCount = RiwayatRekomendasi::query()->where('user_id', '=', Auth::id(), 'and')->count();
        $riwayats = RiwayatRekomendasi::query()->where('user_id', '=', Auth::id(), 'and')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get Top Recommended Batik in Apollo based on catalog
        $topBatik = Alternatif::with(['bahan', 'motif', 'hargaSub', 'warna', 'fungsi'])
            ->limit(4)
            ->get();

        return view('dashboard', compact('katalogCount', 'riwayatCount', 'riwayats', 'topBatik'));
    }

    public function rekomendasi()
    {
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode')->get();

        return view('customer.rekomendasi.index', compact('kriterias'));
    }

    public function prosesRekomendasi(Request $request)
    {
        $request->validate([
            'preferensi' => 'required|array|size:5',
        ]);

        $pref = $request->input('preferensi');

        // Calculate rankings
        $results = $this->ahpService->getRecommendations($pref);

        // Store inside RiwayatRekomendasi table associated with the authenticated user
        $riwayat = RiwayatRekomendasi::create([
            'user_id' => Auth::id(),
            'preferences' => $pref,
            'results' => $results,
        ]);

        return redirect()->route('customer.riwayat.show', $riwayat->id);
    }

    public function riwayat()
    {
        $riwayats = RiwayatRekomendasi::query()->where('user_id', '=', Auth::id(), 'and')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.riwayat.index', compact('riwayats'));
    }

    public function showRiwayat(RiwayatRekomendasi $riwayat)
    {
        // Security check: only allow the owner or admin
        if (Auth::user()->role !== 'admin' && $riwayat->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.riwayat.show', compact('riwayat'));
    }

    public function hapusRiwayat(RiwayatRekomendasi $riwayat)
    {
        /** @disregard */
        $riwayat->delete();

        return redirect()->route('customer.riwayat')->with('success', 'Riwayat pencarian berhasil dihapus!');
    }
}
