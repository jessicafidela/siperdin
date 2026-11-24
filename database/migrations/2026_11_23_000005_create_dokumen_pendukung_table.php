<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pendukung', function (Blueprint $table) {
            $table->increments('id_dokumen_pendukung');
            $table->unsignedInteger('id_detail');
            $table->string('nama_file', 255);
            $table->string('format_file', 20);
            $table->unsignedInteger('ukuran_file')->nullable();
            $table->string('lokasi_penyimpanan', 255);
            $table->dateTime('tanggal_upload');
            $table->string('status_dokumen', 30)->default('diunggah');

            $table->foreign('id_detail')
                ->references('id_detail')->on('detail_perjalanan_dinas')
                ->restrictOnDelete();
            $table->index(['id_detail', 'tanggal_upload']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pendukung');
    }
};
