<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatifs = Alternatif::with(['bahan', 'motif', 'hargaSub', 'warna', 'fungsi'])
            ->orderBy('kode')
            ->get();

        return view('admin.alternatif.index', compact('alternatifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Load sub-criteria groupings for C1, C2, C4, C5 (C3 is automatic based on price)
        $bahans = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C1', 'and'))->get();
        $motifs = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C2', 'and'))->get();
        $warnas = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C4', 'and'))->get();
        $fungsis = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C5', 'and'))->get();

        return view('admin.alternatif.create', compact('bahans', 'motifs', 'warnas', 'fungsis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:alternatifs,kode',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'keterangan' => 'nullable|string',
            'bahan_sub_id' => 'required|exists:sub_kriterias,id',
            'motif_sub_id' => 'required|exists:sub_kriterias,id',
            'warna_sub_id' => 'required|exists:sub_kriterias,id',
            'fungsi_sub_id' => 'required|exists:sub_kriterias,id',
        ]);

        // Automate C3 (Harga) range matching
        $harga = intval($request->harga);
        $c3 = Kriteria::query()->where('kode', '=', 'C3', 'and')->first();
        if ($harga < 150000) {
            $sKode = 'S01';
        } elseif ($harga <= 250000) {
            $sKode = 'S02';
        } elseif ($harga <= 400000) {
            $sKode = 'S03';
        } elseif ($harga <= 700000) {
            $sKode = 'S04';
        } else {
            $sKode = 'S05';
        }
        $hargaSub = SubKriteria::query()
            ->where('kriteria_id', '=', $c3->id, 'and')
            ->where('kode', '=', $sKode, 'and')
            ->first();

        // Handle Image Upload
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('batik', 'public');
        }

        Alternatif::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
            'keterangan' => $request->keterangan,
            'bahan_sub_id' => $request->bahan_sub_id,
            'motif_sub_id' => $request->motif_sub_id,
            'harga_sub_id' => $hargaSub->id,
            'warna_sub_id' => $request->warna_sub_id,
            'fungsi_sub_id' => $request->fungsi_sub_id,
        ]);

        return redirect()->route('admin.alternatif.index')->with('success', 'Batik baru berhasil ditambahkan ke katalog!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternatif $alternatif)
    {
        $bahans = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C1', 'and'))->get();
        $motifs = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C2', 'and'))->get();
        $warnas = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C4', 'and'))->get();
        $fungsis = SubKriteria::whereHas('kriteria', fn($q) => $q->where('kode', '=', 'C5', 'and'))->get();

        return view('admin.alternatif.edit', compact('alternatif', 'bahans', 'motifs', 'warnas', 'fungsis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'kode' => 'required|string|unique:alternatifs,kode,' . $alternatif->id,
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'keterangan' => 'nullable|string',
            'bahan_sub_id' => 'required|exists:sub_kriterias,id',
            'motif_sub_id' => 'required|exists:sub_kriterias,id',
            'warna_sub_id' => 'required|exists:sub_kriterias,id',
            'fungsi_sub_id' => 'required|exists:sub_kriterias,id',
        ]);

        // Automate C3 (Harga) range matching
        $harga = intval($request->harga);
        $c3 = Kriteria::query()->where('kode', '=', 'C3', 'and')->first();
        if ($harga < 150000) {
            $sKode = 'S01';
        } elseif ($harga <= 250000) {
            $sKode = 'S02';
        } elseif ($harga <= 400000) {
            $sKode = 'S03';
        } elseif ($harga <= 700000) {
            $sKode = 'S04';
        } else {
            $sKode = 'S05';
        }
        $hargaSub = SubKriteria::query()
            ->where('kriteria_id', '=', $c3->id, 'and')
            ->where('kode', '=', $sKode, 'and')
            ->first();

        // Handle Image Upload
        $gambarPath = $alternatif->gambar;
        if ($request->hasFile('gambar')) {
            if ($alternatif->gambar) {
                Storage::disk('public')->delete($alternatif->gambar);
            }
            $gambarPath = $request->file('gambar')->store('batik', 'public');
        }

        $alternatif->fill([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
            'keterangan' => $request->keterangan,
            'bahan_sub_id' => $request->bahan_sub_id,
            'motif_sub_id' => $request->motif_sub_id,
            'harga_sub_id' => $hargaSub->id,
            'warna_sub_id' => $request->warna_sub_id,
            'fungsi_sub_id' => $request->fungsi_sub_id,
        ]);
        $alternatif->save();

        return redirect()->route('admin.alternatif.index')->with('success', 'Detail batik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternatif $alternatif)
    {
        if ($alternatif->gambar) {
            Storage::disk('public')->delete($alternatif->gambar);
        }
        /** @disregard */
        $alternatif->delete();

        return redirect()->route('admin.alternatif.index')->with('success', 'Batik berhasil dihapus dari katalog!');
    }
}
