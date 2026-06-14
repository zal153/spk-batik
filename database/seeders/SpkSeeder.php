<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KriteriaComparison;
use App\Models\SubCriteriaComparison;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Users
        User::updateOrCreate(
            ['email' => 'admin@batik.com'],
            [
                'name' => 'Admin Toko Apollo',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@batik.com'],
            [
                'name' => 'Customer Batik',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 2. Seed Kriteria (C1 - C5)
        $kriterias = [
            'C1' => 'Bahan',
            'C2' => 'Motif',
            'C3' => 'Harga',
            'C4' => 'Warna',
            'C5' => 'Fungsi',
        ];

        $criteriaModels = [];
        foreach ($kriterias as $kode => $nama) {
            $criteriaModels[$kode] = Kriteria::updateOrCreate(
                ['kode' => $kode],
                ['nama' => $nama]
            );
        }

        // 3. Seed Sub-Kriteria for each Kriteria
        $subKriteriasData = [
            'C1' => [
                'S01' => 'Sutra',
                'S02' => 'Katun Primissima',
                'S03' => 'Katun Biasa',
                'S04' => 'Rayon',
                'S05' => 'Polyester',
            ],
            'C2' => [
                'S01' => 'Tradisional Asli',
                'S02' => 'Tradisional Modern',
                'S03' => 'Kombinasi',
                'S04' => 'Modern/Kontemporer',
                'S05' => 'Polos Minimalis',
            ],
            'C3' => [
                'S01' => '< Rp 150.000',
                'S02' => 'Rp 150.000-250.000',
                'S03' => 'Rp 250.000-400.000',
                'S04' => 'Rp 400.000-700.000',
                'S05' => '> Rp 700.000',
            ],
            'C4' => [
                'S01' => 'Alami/Natural',
                'S02' => 'Netral Elegan',
                'S03' => 'Cerah Seimbang',
                'S04' => 'Cerah Mencolok',
                'S05' => 'Tidak Harmonis',
            ],
            'C5' => [
                'S01' => 'Multi-fungsi',
                'S02' => 'Dua fungsi',
                'S03' => 'Formal',
                'S04' => 'Casual',
                'S05' => 'Seremonial',
            ],
        ];

        $subCriteriaModels = [];
        foreach ($subKriteriasData as $cKode => $subs) {
            $kriteriaId = $criteriaModels[$cKode]->id;
            foreach ($subs as $sKode => $nama) {
                $subCriteriaModels[$cKode][$sKode] = SubKriteria::updateOrCreate(
                    ['kriteria_id' => $kriteriaId, 'kode' => $sKode],
                    ['nama' => $nama]
                );
            }
        }

        // 4. Seed Kriteria Pairwise Comparisons (Table 3.3, page 42)
        // Format: [C_i, C_j, value]
        $kriteriaComparisons = [
            ['C1', 'C1', 1.0], ['C1', 'C2', 2.0], ['C1', 'C3', 3.0], ['C1', 'C4', 4.0], ['C1', 'C5', 5.0],
            ['C2', 'C1', 0.5], ['C2', 'C2', 1.0], ['C2', 'C3', 2.0], ['C2', 'C4', 3.0], ['C2', 'C5', 4.0],
            ['C3', 'C1', 0.3333], ['C3', 'C2', 0.5], ['C3', 'C3', 1.0], ['C3', 'C4', 2.0], ['C3', 'C5', 3.0],
            ['C4', 'C1', 0.25], ['C4', 'C2', 0.3333], ['C4', 'C3', 0.5], ['C4', 'C4', 1.0], ['C4', 'C5', 2.0],
            ['C5', 'C1', 0.2], ['C5', 'C2', 0.25], ['C5', 'C3', 0.3333], ['C5', 'C4', 0.5], ['C5', 'C5', 1.0],
        ];

        foreach ($kriteriaComparisons as $comp) {
            KriteriaComparison::updateOrCreate([
                'criteria_id_1' => $criteriaModels[$comp[0]]->id,
                'criteria_id_2' => $criteriaModels[$comp[1]]->id,
            ], [
                'value' => $comp[2],
            ]);
        }

        // 5. Seed Sub-Kriteria Pairwise Comparisons (pages 44, 46, 47, 49, 51)
        // Sub-criteria matrices for C1 - C5
        $subComparisons = [
            // C1 (Bahan)
            'C1' => [
                ['S01', 'S01', 1.0], ['S01', 'S02', 3.0], ['S01', 'S03', 5.0], ['S01', 'S04', 7.0], ['S01', 'S05', 9.0],
                ['S02', 'S01', 0.3333], ['S02', 'S02', 1.0], ['S02', 'S03', 3.0], ['S02', 'S04', 5.0], ['S02', 'S05', 6.0],
                ['S03', 'S01', 0.2], ['S03', 'S02', 0.3333], ['S03', 'S03', 1.0], ['S03', 'S04', 2.0], ['S03', 'S05', 4.0],
                ['S04', 'S01', 0.1429], ['S04', 'S02', 0.2], ['S04', 'S03', 0.5], ['S04', 'S04', 1.0], ['S04', 'S05', 3.0],
                ['S05', 'S01', 0.1111], ['S05', 'S02', 0.1667], ['S05', 'S03', 0.25], ['S05', 'S04', 0.3333], ['S05', 'S05', 1.0],
            ],
            // C2 (Motif)
            'C2' => [
                ['S01', 'S01', 1.0], ['S01', 'S02', 3.0], ['S01', 'S03', 5.0], ['S01', 'S04', 7.0], ['S01', 'S05', 9.0],
                ['S02', 'S01', 0.3333], ['S02', 'S02', 1.0], ['S02', 'S03', 3.0], ['S02', 'S04', 5.0], ['S02', 'S05', 7.0],
                ['S03', 'S01', 0.2], ['S03', 'S02', 0.3333], ['S03', 'S03', 1.0], ['S03', 'S04', 3.0], ['S03', 'S05', 5.0],
                ['S04', 'S01', 0.1429], ['S04', 'S02', 0.2], ['S04', 'S03', 0.3333], ['S04', 'S04', 1.0], ['S04', 'S05', 3.0],
                ['S05', 'S01', 0.1111], ['S05', 'S02', 0.1429], ['S05', 'S03', 0.2], ['S05', 'S04', 0.3333], ['S05', 'S05', 1.0],
            ],
            // C3 (Harga)
            'C3' => [
                ['S01', 'S01', 1.0], ['S01', 'S02', 3.0], ['S01', 'S03', 5.0], ['S01', 'S04', 7.0], ['S01', 'S05', 9.0],
                ['S02', 'S01', 0.3333], ['S02', 'S02', 1.0], ['S02', 'S03', 2.0], ['S02', 'S04', 5.0], ['S02', 'S05', 7.0],
                ['S03', 'S01', 0.2], ['S03', 'S02', 0.5], ['S03', 'S03', 1.0], ['S03', 'S04', 3.0], ['S03', 'S05', 5.0],
                ['S04', 'S01', 0.1429], ['S04', 'S02', 0.2], ['S04', 'S03', 0.3333], ['S04', 'S04', 1.0], ['S04', 'S05', 3.0],
                ['S05', 'S01', 0.1111], ['S05', 'S02', 0.1429], ['S05', 'S03', 0.2], ['S05', 'S04', 0.3333], ['S05', 'S05', 1.0],
            ],
            // C4 (Warna)
            'C4' => [
                ['S01', 'S01', 1.0], ['S01', 'S02', 3.0], ['S01', 'S03', 5.0], ['S01', 'S04', 7.0], ['S01', 'S05', 9.0],
                ['S02', 'S01', 0.3333], ['S02', 'S02', 1.0], ['S02', 'S03', 2.0], ['S02', 'S04', 4.0], ['S02', 'S05', 7.0],
                ['S03', 'S01', 0.2], ['S03', 'S02', 0.5], ['S03', 'S03', 1.0], ['S03', 'S04', 3.0], ['S03', 'S05', 5.0],
                ['S04', 'S01', 0.1429], ['S04', 'S02', 0.25], ['S04', 'S03', 0.3333], ['S04', 'S04', 1.0], ['S04', 'S05', 3.0],
                ['S05', 'S01', 0.1111], ['S05', 'S02', 0.1429], ['S05', 'S03', 0.2], ['S05', 'S04', 0.3333], ['S05', 'S05', 1.0],
            ],
            // C5 (Fungsi)
            'C5' => [
                ['S01', 'S01', 1.0], ['S01', 'S02', 3.0], ['S01', 'S03', 5.0], ['S01', 'S04', 7.0], ['S01', 'S05', 9.0],
                ['S02', 'S01', 0.3333], ['S02', 'S02', 1.0], ['S02', 'S03', 3.0], ['S02', 'S04', 5.0], ['S02', 'S05', 7.0],
                ['S03', 'S01', 0.2], ['S03', 'S02', 0.3333], ['S03', 'S03', 1.0], ['S03', 'S04', 1.0], ['S03', 'S05', 5.0],
                ['S04', 'S01', 0.1429], ['S04', 'S02', 0.2], ['S04', 'S03', 1.0], ['S04', 'S04', 1.0], ['S04', 'S05', 3.0],
                ['S05', 'S01', 0.1111], ['S05', 'S02', 0.1429], ['S05', 'S03', 0.2], ['S05', 'S04', 0.3333], ['S05', 'S05', 1.0],
            ],
        ];

        foreach ($subComparisons as $cKode => $comps) {
            $kriteriaId = $criteriaModels[$cKode]->id;
            foreach ($comps as $comp) {
                SubCriteriaComparison::updateOrCreate([
                    'kriteria_id' => $kriteriaId,
                    'sub_criteria_id_1' => $subCriteriaModels[$cKode][$comp[0]]->id,
                    'sub_criteria_id_2' => $subCriteriaModels[$cKode][$comp[1]]->id,
                ], [
                    'value' => $comp[2],
                ]);
            }
        }

        // 6. Seed Batik Products (Table 3.1, pages 22-23)
        $batikProducts = [
            [
                'kode' => 'B001',
                'nama' => 'Batik Parang Sutra',
                'harga' => 850000,
                'keterangan' => 'Batik Parang Sutra berkualitas tinggi dengan bahan Sutra, motif Tradisional Asli, warna Alami/Natural, dan cocok untuk penggunaan Multi-fungsi.',
                'bahan' => 'S01',
                'motif' => 'S01',
                'harga_range' => 'S05',
                'warna' => 'S01',
                'fungsi' => 'S01',
            ],
            [
                'kode' => 'B002',
                'nama' => 'Batik Cap Katun',
                'harga' => 200000,
                'keterangan' => 'Batik Cap Katun berkualitas tinggi dengan bahan Katun Primissima, motif Tradisional Modern, warna Netral Elegan, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S02',
                'motif' => 'S02',
                'harga_range' => 'S02',
                'warna' => 'S02',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B003',
                'nama' => 'Batik Modern Rayon',
                'harga' => 120000,
                'keterangan' => 'Batik Modern Rayon berkualitas tinggi dengan bahan Rayon, motif Modern/Kontemporer, warna Cerah Mencolok, dan cocok untuk penggunaan Casual.',
                'bahan' => 'S04',
                'motif' => 'S04',
                'harga_range' => 'S01',
                'warna' => 'S04',
                'fungsi' => 'S04',
            ],
            [
                'kode' => 'B004',
                'nama' => 'Batik Kombinasi Katun',
                'harga' => 320000,
                'keterangan' => 'Batik Kombinasi Katun berkualitas tinggi dengan bahan Katun Biasa, motif Kombinasi, warna Cerah Seimbang, dan cocok untuk penggunaan Dua Fungsi.',
                'bahan' => 'S03',
                'motif' => 'S03',
                'harga_range' => 'S03',
                'warna' => 'S03',
                'fungsi' => 'S02',
            ],
            [
                'kode' => 'B005',
                'nama' => 'Batik Kawung Sutra',
                'harga' => 950000,
                'keterangan' => 'Batik Kawung Sutra berkualitas tinggi dengan bahan Sutra, motif Tradisional Asli, warna Netral Elegan, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S01',
                'motif' => 'S01',
                'harga_range' => 'S05',
                'warna' => 'S02',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B006',
                'nama' => 'Batik Pekalongan',
                'harga' => 500000,
                'keterangan' => 'Batik Pekalongan berkualitas tinggi dengan bahan Katun Sutra, motif Modern/Kontemporer, warna Cerah Mencolok, dan cocok untuk penggunaan Casual.',
                'bahan' => 'S01',
                'motif' => 'S04',
                'harga_range' => 'S04',
                'warna' => 'S04',
                'fungsi' => 'S04',
            ],
            [
                'kode' => 'B007',
                'nama' => 'Batik Solo',
                'harga' => 600000,
                'keterangan' => 'Batik Solo berkualitas tinggi dengan bahan Sutra, motif Kombinasi, warna Alami/Natural, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S01',
                'motif' => 'S03',
                'harga_range' => 'S04',
                'warna' => 'S01',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B008',
                'nama' => 'Batik Yogyakarta',
                'harga' => 750000,
                'keterangan' => 'Batik Yogyakarta berkualitas tinggi dengan bahan Katun Biasa, motif Tradisional Asli, warna Netral Elegan, dan cocok untuk penggunaan Seremonial.',
                'bahan' => 'S03',
                'motif' => 'S01',
                'harga_range' => 'S05',
                'warna' => 'S02',
                'fungsi' => 'S05',
            ],
            [
                'kode' => 'B009',
                'nama' => 'Batik Cirebon',
                'harga' => 450000,
                'keterangan' => 'Batik Cirebon berkualitas tinggi dengan bahan Katun Biasa, motif Modern/Kontemporer, warna Cerah Mencolok, dan cocok untuk penggunaan Casual.',
                'bahan' => 'S03',
                'motif' => 'S04',
                'harga_range' => 'S04',
                'warna' => 'S04',
                'fungsi' => 'S04',
            ],
            [
                'kode' => 'B010',
                'nama' => 'Batik Sumenep',
                'harga' => 100000,
                'keterangan' => 'Batik Sumenep berkualitas tinggi dengan bahan Katun Biasa, motif Tradisional Asli, warna Netral Elegan, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S03',
                'motif' => 'S01',
                'harga_range' => 'S01',
                'warna' => 'S02',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B011',
                'nama' => 'Batik Madura',
                'harga' => 500000,
                'keterangan' => 'Batik Madura berkualitas tinggi dengan bahan Katun Biasa, motif Modern/Kontemporer, warna Cerah Mencolok, dan cocok untuk penggunaan Seremonial.',
                'bahan' => 'S03',
                'motif' => 'S04',
                'harga_range' => 'S04',
                'warna' => 'S04',
                'fungsi' => 'S05',
            ],
            [
                'kode' => 'B012',
                'nama' => 'Batik Bali',
                'harga' => 300000,
                'keterangan' => 'Batik Bali berkualitas tinggi dengan bahan Rayon, motif Modern/Kontemporer, warna Cerah Mencolok, dan cocok untuk penggunaan Casual.',
                'bahan' => 'S04',
                'motif' => 'S04',
                'harga_range' => 'S03',
                'warna' => 'S04',
                'fungsi' => 'S04',
            ],
            [
                'kode' => 'B013',
                'nama' => 'Batik Tuban',
                'harga' => 750000,
                'keterangan' => 'Batik Tuban berkualitas tinggi dengan bahan Katun Biasa, motif Tradisional Asli, warna Alami/Natural, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S03',
                'motif' => 'S01',
                'harga_range' => 'S05',
                'warna' => 'S01',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B014',
                'nama' => 'Batik Jawa',
                'harga' => 125000,
                'keterangan' => 'Batik Jawa berkualitas tinggi dengan bahan Sutra, motif Tradisional Asli, warna Alami/Natural, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S01',
                'motif' => 'S01',
                'harga_range' => 'S01',
                'warna' => 'S01',
                'fungsi' => 'S03',
            ],
            [
                'kode' => 'B015',
                'nama' => 'Batik Pamekasan',
                'harga' => 300000,
                'keterangan' => 'Batik Pamekasan berkualitas tinggi dengan bahan Katun Biasa, motif Tradisional Asli, warna Cerah Seimbang, dan cocok untuk penggunaan Casual.',
                'bahan' => 'S03',
                'motif' => 'S01',
                'harga_range' => 'S03',
                'warna' => 'S03',
                'fungsi' => 'S04',
            ],
            [
                'kode' => 'B016',
                'nama' => 'Batik Tanjung Bumi',
                'harga' => 200000,
                'keterangan' => 'Batik Tanjung Bumi berkualitas tinggi dengan bahan Katun Biasa, motif Tradisional Asli, warna Cerah Mencolok, dan cocok untuk penggunaan Formal.',
                'bahan' => 'S03',
                'motif' => 'S01',
                'harga_range' => 'S02',
                'warna' => 'S04',
                'fungsi' => 'S03',
            ],
        ];

        foreach ($batikProducts as $prod) {
            Alternatif::updateOrCreate(
                ['kode' => $prod['kode']],
                [
                    'nama' => $prod['nama'],
                    'harga' => $prod['harga'],
                    'keterangan' => $prod['keterangan'],
                    'bahan_sub_id' => $subCriteriaModels['C1'][$prod['bahan']]->id,
                    'motif_sub_id' => $subCriteriaModels['C2'][$prod['motif']]->id,
                    'harga_sub_id' => $subCriteriaModels['C3'][$prod['harga_range']]->id,
                    'warna_sub_id' => $subCriteriaModels['C4'][$prod['warna']]->id,
                    'fungsi_sub_id' => $subCriteriaModels['C5'][$prod['fungsi']]->id,
                ]
            );
        }
    }
}
