<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_administrasi', function (Blueprint $table) {
            $table->increments('id_dokumen_adm');
            $table->unsignedInteger('id_perjalanan');
            // Nullable agar dokumen kolektif (misalnya nominatif/SPTB) tidak dipaksa terkait ke satu pegawai.
            $table->unsignedInteger('id_detail')->nullable();
            $table->unsignedInteger('id_template');
            $table->string('jenis_dokumen', 50);
            $table->string('nomor_dokumen', 50)->nullable()->unique();
            $table->date('tanggal_dokumen')->nullable();

            $table->foreign('id_perjalanan')
                ->references('id_perjalanan')->on('perjalanan_dinas')
                ->restrictOnDelete();
            $table->foreign('id_detail')
                ->references('id_detail')->on('detail_perjalanan_dinas')
                ->restrictOnDelete();
            $table->foreign('id_template')
                ->references('id_template')->on('template_dokumen')
                ->restrictOnDelete();

            $table->index(['id_perjalanan', 'jenis_dokumen']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_administrasi');
    }
};
