<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments('id_pegawai');
            $table->unsignedInteger('id_satker');
            $table->string('nip', 30)->nullable()->unique();
            $table->string('nip_baru', 30)->nullable()->unique();
            $table->string('nama_lengkap', 100);
            $table->string('pangkat', 50)->nullable();
            $table->string('gol_ruang', 20)->nullable();
            $table->string('tipe_jabatan', 50)->nullable();
            $table->string('tampil_jabatan', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_satker')
                ->references('id_satker')->on('satuan_kerja')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
