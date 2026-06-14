<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KriteriaComparison;
use App\Models\SubCriteriaComparison;
use App\Models\SubKriteria;

class AhpService
{
    private array $riTable = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
    ];

    /**
     * Calculate weights for a given pairwise comparison matrix.
     * Returns weights, lambda_max, CI, CR, and consistency check.
     */
    public function calculateAhp(array $matrix): array
    {
        $n = count($matrix);
        if ($n === 0) {
            return [
                'weights' => [],
                'lambda_max' => 0,
                'ci' => 0,
                'cr' => 0,
                'is_consistent' => true,
            ];
        }

        // 1. Calculate column sums
        $colSums = [];
        for ($j = 1; $j <= $n; $j++) {
            $sum = 0;
            for ($i = 1; $i <= $n; $i++) {
                $sum += $matrix[$i][$j] ?? 1.0;
            }
            $colSums[$j] = $sum;
        }

        // 2. Normalize matrix and calculate row averages (weights)
        $weights = [];
        for ($i = 1; $i <= $n; $i++) {
            $rowSum = 0;
            for ($j = 1; $j <= $n; $j++) {
                $cellValue = $matrix[$i][$j] ?? 1.0;
                $colSum = $colSums[$j] ?: 1.0;
                $rowSum += $cellValue / $colSum;
            }
            $weights[$i] = $rowSum / $n;
        }

        // 3. Consistency check (A * w)
        $aw = [];
        for ($i = 1; $i <= $n; $i++) {
            $sum = 0;
            for ($j = 1; $j <= $n; $j++) {
                $cellValue = $matrix[$i][$j] ?? 1.0;
                $sum += $cellValue * $weights[$j];
            }
            $aw[$i] = $sum;
        }

        // 4. Calculate lambda max
        $lambdaSum = 0;
        for ($i = 1; $i <= $n; $i++) {
            $lambdaSum += $aw[$i] / ($weights[$i] ?: 1.0);
        }
        $lambdaMax = $lambdaSum / $n;

        // 5. Consistency Index (CI)
        $ci = $n > 1 ? ($lambdaMax - $n) / ($n - 1) : 0.0;

        // 6. Consistency Ratio (CR)
        $ri = $this->riTable[$n] ?? 1.12;
        $cr = $ri > 0 ? $ci / $ri : 0.0;
        $isConsistent = $cr <= 0.1;

        return [
            'weights' => $weights,
            'lambda_max' => round($lambdaMax, 4),
            'ci' => round($ci, 4),
            'cr' => round($cr, 4),
            'is_consistent' => $isConsistent,
        ];
    }

    /**
     * Compute and save all criteria and sub-criteria weights in the database.
     * Returns a summary of the consistency checks.
     */
    public function updateAllWeights(): array
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        $n = $kriterias->count();

        // --- 1. CRITERIA AHP WEIGHTS ---
        $cMatrix = [];
        $kMap = [];
        $idx = 1;
        foreach ($kriterias as $k) {
            $kMap[$k->id] = $idx;
            $kMapIdx[$idx] = $k->id;
            $idx++;
        }

        // Initialize diagonal and reciprocity
        for ($i = 1; $i <= $n; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $cMatrix[$i][$j] = 1.0;
            }
        }

        $cComparisons = KriteriaComparison::all();
        foreach ($cComparisons as $comp) {
            if (isset($kMap[$comp->criteria_id_1]) && isset($kMap[$comp->criteria_id_2])) {
                $i = $kMap[$comp->criteria_id_1];
                $j = $kMap[$comp->criteria_id_2];
                $cMatrix[$i][$j] = $comp->value;
                $cMatrix[$j][$i] = $comp->value != 0 ? 1 / $comp->value : 1.0;
            }
        }

        $cResult = $this->calculateAhp($cMatrix);

        // Save criteria weights
        foreach ($cResult['weights'] as $i => $weight) {
            $kId = $kMapIdx[$i];
            Kriteria::where('id', $kId)->update(['bobot' => $weight]);
        }

        $summary = [
            'criteria' => [
                'cr' => $cResult['cr'],
                'is_consistent' => $cResult['is_consistent'],
            ],
            'sub_criteria' => [],
        ];

        // --- 2. SUB-CRITERIA AHP WEIGHTS ---
        foreach ($kriterias as $k) {
            $subs = $k->subKriterias()->orderBy('kode')->get();
            $m = $subs->count();

            if ($m === 0) {
                continue;
            }

            $sMatrix = [];
            $sMap = [];
            $sIdx = 1;
            foreach ($subs as $s) {
                $sMap[$s->id] = $sIdx;
                $sMapIdx[$sIdx] = $s->id;
                $sIdx++;
            }

            for ($i = 1; $i <= $m; $i++) {
                for ($j = 1; $j <= $m; $j++) {
                    $sMatrix[$i][$j] = 1.0;
                }
            }

            $sComparisons = SubCriteriaComparison::where('kriteria_id', $k->id)->get();
            foreach ($sComparisons as $comp) {
                if (isset($sMap[$comp->sub_criteria_id_1]) && isset($sMap[$comp->sub_criteria_id_2])) {
                    $i = $sMap[$comp->sub_criteria_id_1];
                    $j = $sMap[$comp->sub_criteria_id_2];
                    $sMatrix[$i][$j] = $comp->value;
                    $sMatrix[$j][$i] = $comp->value != 0 ? 1 / $comp->value : 1.0;
                }
            }

            $sResult = $this->calculateAhp($sMatrix);

            // Save sub-criteria weights
            foreach ($sResult['weights'] as $i => $weight) {
                $sId = $sMapIdx[$i];
                SubKriteria::where('id', $sId)->update(['bobot' => $weight]);
            }

            $summary['sub_criteria'][$k->kode] = [
                'nama' => $k->nama,
                'cr' => $sResult['cr'],
                'is_consistent' => $sResult['is_consistent'],
            ];
        }

        return $summary;
    }

    /**
     * Calculate SPK recommendation for alternatives based on customer preferences.
     * Formula: Kecocokan = 100 - (25 * TotalSelisih)
     * TotalSelisih = Sum( BobotKriteria * |SubKriteriaAlternatif - SubKriteriaUser| )
     */
    public function getRecommendations(array $preferences): array
    {
        // First ensure weights are up to date in the DB
        $this->updateAllWeights();

        $kriterias = Kriteria::with('subKriterias')->get()->keyBy('kode');
        $alternatifs = Alternatif::with(['bahan', 'motif', 'hargaSub', 'warna', 'fungsi'])->get();

        // Build preferences weight map
        // Preferences contains [ 'C1' => sub_criteria_id, 'C2' => sub_criteria_id, ... ]
        $prefWeights = [];
        foreach ($preferences as $cKode => $subId) {
            $sub = SubKriteria::find($subId);
            $prefWeights[$cKode] = $sub ? $sub->bobot : 0.0;
        }

        $results = [];

        foreach ($alternatifs as $alt) {
            $totalSelisih = 0.0;

            // Map criteria to the alternative's sub-criteria bobot
            $altSubWeights = [
                'C1' => $alt->bahan->bobot ?? 0.0,
                'C2' => $alt->motif->bobot ?? 0.0,
                'C3' => $alt->hargaSub->bobot ?? 0.0,
                'C4' => $alt->warna->bobot ?? 0.0,
                'C5' => $alt->fungsi->bobot ?? 0.0,
            ];

            // Detail difference calculations for reporting/debugging
            $details = [];

            foreach ($kriterias as $cKode => $k) {
                $w_c = $k->bobot ?? 0.0;
                $v_a = $altSubWeights[$cKode];
                $v_u = $prefWeights[$cKode] ?? 0.0;
                $selisih = abs($v_a - $v_u);
                $weightedSelisih = $w_c * $selisih;

                $totalSelisih += $weightedSelisih;

                $details[$cKode] = [
                    'kriteria' => $k->nama,
                    'bobot_kriteria' => $w_c,
                    'nilai_produk' => $v_a,
                    'nilai_preferensi' => $v_u,
                    'selisih' => $selisih,
                    'selisih_bobot' => $weightedSelisih,
                ];
            }

            // Formula: Kecocokan = 100 - (25 * TotalSelisih)
            $kecocokan = 100.0 - (25.0 * $totalSelisih);
            if ($kecocokan < 0.0) {
                $kecocokan = 0.0;
            }

            $results[] = [
                'alternatif_id' => $alt->id,
                'kode' => $alt->kode,
                'nama' => $alt->nama,
                'harga' => $alt->harga,
                'gambar' => $alt->gambar,
                'keterangan' => $alt->keterangan,
                'spesifikasi' => [
                    'bahan' => $alt->bahan->nama ?? '-',
                    'motif' => $alt->motif->nama ?? '-',
                    'harga' => $alt->hargaSub->nama ?? '-',
                    'warna' => $alt->warna->nama ?? '-',
                    'fungsi' => $alt->fungsi->nama ?? '-',
                ],
                'total_selisih' => round($totalSelisih, 4),
                'kecocokan' => round($kecocokan, 2),
                'details' => $details,
            ];
        }

        // Sort by kecocokan descending, then by price ascending
        usort($results, function ($a, $b) {
            if ($a['kecocokan'] == $b['kecocokan']) {
                return $a['harga'] <=> $b['harga'];
            }

            return $b['kecocokan'] <=> $a['kecocokan'];
        });

        return $results;
    }
}
