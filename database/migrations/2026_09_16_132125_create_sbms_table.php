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
        Schema::create('sbms', function (Blueprint $table) {

            $table->id();
            $table->string('kode_sbm')->unique();
            $table->string('kategori');
            $table->string('nama_biaya');
            $table->string('satuan');
            $table->decimal('nilai', 15, 2);
            $table->enum('jenis_batas', [
                'batas_tertinggi',
                'dapat_dilampaui',
            ]);
            $table->year('tahun_anggaran');
            $table->enum('status', [
                'aktif',
                'tidak_aktif',
            ])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbms');
    }
};
