<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\KriteriaComparison;
use App\Models\SubCriteriaComparison;
use App\Services\AhpService;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function __construct(protected AhpService $ahpService) {}

    public function index()
    {
        // Get all criteria & sub-criteria
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode')->get();

        // 1. Build Criteria Comparison Matrix values for the view
        $criteriaComparisons = [];
        $cComps = KriteriaComparison::all();
        foreach ($cComps as $comp) {
            $criteriaComparisons[$comp->criteria_id_1][$comp->criteria_id_2] = $comp->value;
        }

        // 2. Build Sub-criteria Comparison Matrices for the view
        $subComparisons = [];
        $sComps = SubCriteriaComparison::all();
        foreach ($sComps as $comp) {
            $subComparisons[$comp->kriteria_id][$comp->sub_criteria_id_1][$comp->sub_criteria_id_2] = $comp->value;
        }

        // Run calculation once to ensure latest calculations are loaded and consistent summary is available
        $ahpSummary = $this->ahpService->updateAllWeights();

        // Re-load criteria to get updated weights
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode')->get();

        return view('admin.kriteria.index', compact('kriterias', 'criteriaComparisons', 'subComparisons', 'ahpSummary'));
    }

    public function updateComparison(Request $request)
    {
        $request->validate([
            'comparison' => 'required|array',
        ]);

        foreach ($request->input('comparison') as $id1 => $targets) {
            foreach ($targets as $id2 => $value) {
                // Ensure value is numeric and positive
                $val = floatval($value);
                if ($val <= 0) {
                    $val = 1.0;
                }

                // Update the comparison value
                KriteriaComparison::updateOrCreate(
                    ['criteria_id_1' => $id1, 'criteria_id_2' => $id2],
                    ['value' => $val]
                );

                // Update the reciprocal value
                KriteriaComparison::updateOrCreate(
                    ['criteria_id_1' => $id2, 'criteria_id_2' => $id1],
                    ['value' => $val != 0 ? 1 / $val : 1.0]
                );
            }
        }

        // Recalculate weights
        $this->ahpService->updateAllWeights();

        return redirect()->route('admin.kriteria.index')->with('success', 'Matriks perbandingan kriteria berhasil diperbarui!');
    }

    public function updateSubComparison(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'comparison' => 'required|array',
        ]);

        $kriteriaId = $request->input('kriteria_id');

        foreach ($request->input('comparison') as $id1 => $targets) {
            foreach ($targets as $id2 => $value) {
                $val = floatval($value);
                if ($val <= 0) {
                    $val = 1.0;
                }

                // Update comparison
                SubCriteriaComparison::updateOrCreate(
                    ['kriteria_id' => $kriteriaId, 'sub_criteria_id_1' => $id1, 'sub_criteria_id_2' => $id2],
                    ['value' => $val]
                );

                // Update reciprocal
                SubCriteriaComparison::updateOrCreate(
                    ['kriteria_id' => $kriteriaId, 'sub_criteria_id_1' => $id2, 'sub_criteria_id_2' => $id1],
                    ['value' => $val != 0 ? 1 / $val : 1.0]
                );
            }
        }

        // Recalculate weights
        $this->ahpService->updateAllWeights();

        return redirect()->route('admin.kriteria.index')->with('success', 'Matriks perbandingan sub-kriteria berhasil diperbarui!');
    }

    public function recalculate()
    {
        $this->ahpService->updateAllWeights();

        return redirect()->route('admin.kriteria.index')->with('success', 'Bobot AHP berhasil dihitung ulang!');
    }
}
