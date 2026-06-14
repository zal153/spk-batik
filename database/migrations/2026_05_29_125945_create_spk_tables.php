<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->double('bobot')->nullable();
            $table->timestamps();
        });

        Schema::create('sub_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->string('kode');
            $table->string('nama');
            $table->double('bobot')->nullable();
            $table->timestamps();
        });

        Schema::create('kriteria_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id_1')->constrained('kriterias')->onDelete('cascade');
            $table->foreignId('criteria_id_2')->constrained('kriterias')->onDelete('cascade');
            $table->double('value');
            $table->timestamps();
        });

        Schema::create('sub_criteria_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->foreignId('sub_criteria_id_1')->constrained('sub_kriterias')->onDelete('cascade');
            $table->foreignId('sub_criteria_id_2')->constrained('sub_kriterias')->onDelete('cascade');
            $table->double('value');
            $table->timestamps();
        });

        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->integer('harga');
            $table->string('gambar')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('bahan_sub_id')->constrained('sub_kriterias')->onDelete('cascade');
            $table->foreignId('motif_sub_id')->constrained('sub_kriterias')->onDelete('cascade');
            $table->foreignId('harga_sub_id')->constrained('sub_kriterias')->onDelete('cascade');
            $table->foreignId('warna_sub_id')->constrained('sub_kriterias')->onDelete('cascade');
            $table->foreignId('fungsi_sub_id')->constrained('sub_kriterias')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('riwayat_rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->json('preferences');
            $table->json('results');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_rekomendasis');
        Schema::dropIfExists('alternatifs');
        Schema::dropIfExists('sub_criteria_comparisons');
        Schema::dropIfExists('kriteria_comparisons');
        Schema::dropIfExists('sub_kriterias');
        Schema::dropIfExists('kriterias');
    }
};
