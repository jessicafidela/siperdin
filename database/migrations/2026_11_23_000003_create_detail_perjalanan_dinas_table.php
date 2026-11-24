<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_perjalanan_dinas', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_perjalanan');
            $table->unsignedInteger('id_pegawai');
            $table->unsignedInteger('id_tempat_asal');
            $table->unsignedInteger('id_tempat_tujuan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('transportasi', 50)->nullable();
            $table->unsignedInteger('lama_perjalanan');
            $table->timestamps();

            $table->foreign('id_perjalanan')
                ->references('id_perjalanan')->on('perjalanan_dinas')
                ->restrictOnDelete();
            $table->foreign('id_pegawai')
                ->references('id_pegawai')->on('pegawai')
                ->restrictOnDelete();
            $table->foreign('id_tempat_asal')
                ->references('id_tempat')->on('tempat')
                ->restrictOnDelete();
            $table->foreign('id_tempat_tujuan')
                ->references('id_tempat')->on('tempat')
                ->restrictOnDelete();

            $table->index(['id_perjalanan', 'id_pegawai']);
            $table->index(['tanggal_berangkat', 'tanggal_kembali']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_perjalanan_dinas');
    }
};
