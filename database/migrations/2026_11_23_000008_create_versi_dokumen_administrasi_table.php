<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('versi_dokumen_administrasi', function (Blueprint $table) {
            $table->increments('id_versi');
            $table->unsignedInteger('id_dokumen_adm');
            $table->unsignedInteger('nomor_versi');
            $table->string('status_validasi', 30)->default('belum_divalidasi');
            $table->json('konten_draft');
            $table->string('lokasi_penyimpanan', 255)->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->unsignedInteger('created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('validated_at')->nullable();

            $table->foreign('id_dokumen_adm')
                ->references('id_dokumen_adm')->on('dokumen_administrasi')
                ->restrictOnDelete();
            $table->foreign('created_by')
                ->references('id_user')->on('users')
                ->restrictOnDelete();

            $table->unique(['id_dokumen_adm', 'nomor_versi'], 'versi_dokumen_nomor_unique');
            $table->index(['id_dokumen_adm', 'status_validasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versi_dokumen_administrasi');
    }
};
