<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->increments('id_perjalanan');
            $table->unsignedInteger('id_satker');
            $table->unsignedInteger('created_by');
            $table->string('nomor_pengajuan', 50)->unique();
            $table->date('tanggal_pengajuan');
            $table->string('kegiatan', 150);
            $table->text('misi_perjalanan')->nullable();
            $table->string('status_pengajuan', 50)->default('draft');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('id_satker')
                ->references('id_satker')->on('satuan_kerja')
                ->restrictOnDelete();
            $table->foreign('created_by')
                ->references('id_user')->on('users')
                ->restrictOnDelete();
            $table->index(['id_satker', 'status_pengajuan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};
