<?php

use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Database\Seeders\SpkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('recommendation page requires authentication', function () {
    $this->get(route('customer.rekomendasi'))
        ->assertRedirect(route('login'));
});

test('authenticated customer can view recommendation page and form inputs', function () {
    $this->seed(SpkSeeder::class);
    $user = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($user)
        ->get(route('customer.rekomendasi'));

    $response->assertStatus(200);
    $response->assertSee('pref-C1');
    $response->assertSee('pref-C2');
    $response->assertSee('pref-C3');
    $response->assertSee('pref-C4');
    $response->assertSee('pref-C5');
});

test('customer can submit recommendation preference form', function () {
    $this->seed(SpkSeeder::class);
    $user = User::factory()->create(['role' => 'customer']);

    $bahan = Kriteria::where('kode', 'C1')->first();
    $motif = Kriteria::where('kode', 'C2')->first();
    $harga = Kriteria::where('kode', 'C3')->first();
    $warna = Kriteria::where('kode', 'C4')->first();
    $fungsi = Kriteria::where('kode', 'C5')->first();

    $preferences = [
        'C1' => $bahan->subKriterias->first()->id,
        'C2' => $motif->subKriterias->first()->id,
        'C3' => $harga->subKriterias->first()->id,
        'C4' => $warna->subKriterias->first()->id,
        'C5' => $fungsi->subKriterias->first()->id,
    ];

    $response = $this->actingAs($user)
        ->post(route('customer.rekomendasi.proses'), [
            'preferensi' => $preferences
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('riwayat_rekomendasis', [
        'user_id' => $user->id,
    ]);
});
