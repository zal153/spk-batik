<?php

use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Services\AhpService;
use Database\Seeders\SpkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('ahp service correctly calculates weight and consistency ratio', function () {
    $service = new AhpService;

    // 3x3 consistent matrix
    $matrix = [
        1 => [1 => 1.0, 2 => 2.0, 3 => 3.0],
        2 => [1 => 0.5, 2 => 1.0, 3 => 2.0],
        3 => [1 => 0.3333, 2 => 0.5, 3 => 1.0],
    ];

    $result = $service->calculateAhp($matrix);

    expect($result['is_consistent'])->toBeTrue();
    expect($result['weights'][1])->toBeGreaterThan($result['weights'][2]);
    expect($result['weights'][2])->toBeGreaterThan($result['weights'][3]);
});

test('ahp service updates all weights from database and gives recommendations', function () {
    // Seed database first
    $this->seed(SpkSeeder::class);

    $service = new AhpService;
    $summary = $service->updateAllWeights();

    // Verify consistency flags from seeded values in proposal
    expect($summary['criteria']['is_consistent'])->toBeTrue();
    expect($summary['sub_criteria']['C1']['is_consistent'])->toBeTrue();

    // Verify weights are updated in the DB
    $bahan = Kriteria::where('kode', 'C1')->first();
    expect($bahan->bobot)->toBeGreaterThan(0.40)->toBeLessThan(0.43);

    $sutra = SubKriteria::where('kode', 'S01')->where('kriteria_id', $bahan->id)->first();
    expect($sutra->bobot)->toBeGreaterThan(0.50)->toBeLessThan(0.53);

    // Verify recommendations calculation
    // Customer prefers:
    // C1 - Bahan: Katun Primissima (S02)
    // C2 - Motif: Kombinasi (S03)
    // C3 - Harga: < Rp 150.000 (S01)
    // C4 - Warna: Cerah Seimbang (S03)
    // C5 - Fungsi: Casual (S04)
    $preferences = [
        'C1' => SubKriteria::where('kode', 'S02')->where('kriteria_id', $bahan->id)->first()->id,
        'C2' => SubKriteria::where('kode', 'S03')->where('kriteria_id', Kriteria::where('kode', 'C2')->first()->id)->first()->id,
        'C3' => SubKriteria::where('kode', 'S01')->where('kriteria_id', Kriteria::where('kode', 'C3')->first()->id)->first()->id,
        'C4' => SubKriteria::where('kode', 'S03')->where('kriteria_id', Kriteria::where('kode', 'C4')->first()->id)->first()->id,
        'C5' => SubKriteria::where('kode', 'S04')->where('kriteria_id', Kriteria::where('kode', 'C5')->first()->id)->first()->id,
    ];

    $recommendations = $service->getRecommendations($preferences);

    // According to the proposal table 3.23 (page 55):
    // Rank 1: Batik Cap Katun (97.72% or close depending on precision/rounding in AHP weight seeding)
    expect($recommendations)->not->toBeEmpty();
    expect($recommendations[0]['nama'])->toBe('Batik Cap Katun');
    expect($recommendations[0]['kecocokan'])->toBeGreaterThan(95.0)->toBeLessThan(99.0);
});
