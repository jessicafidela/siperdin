<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standar_biaya_masukan', function (Blueprint $table) {
            $table->increments('id_sbm');
            $table->year('tahun_berlaku');
            $table->string('jenis_biaya', 50);
            $table->string('gol_ruang', 20)->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->decimal('nilai_biaya', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standar_biaya_masukan');
    }
};
