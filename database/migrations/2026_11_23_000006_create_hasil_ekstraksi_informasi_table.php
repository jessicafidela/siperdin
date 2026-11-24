
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_ekstraksi_informasi', function (Blueprint $table) {
            $table->increments('id_hasil_ekstraksi');

            $table->unsignedInteger('id_dokumen_pendukung');
            $table->unsignedInteger('versi_ekstraksi');

            $table->json('hasil_ekstraksi');

            // Penyuntingan pengguna dilakukan pada draf dokumen,
            // bukan pada JSON asli hasil ekstraksi.
            $table->decimal('tingkat_kepercayaan', 5, 2)->nullable();
            $table->dateTime('waktu_ekstraksi');
            $table->boolean('status_aktif')->default(false);
            $table->string('status_proses', 30)->default('menunggu');

            $table->foreign('id_dokumen_pendukung')
                ->references('id_dokumen_pendukung')
                ->on('dokumen_pendukung')
                ->restrictOnDelete();

            // Nama index dibuat pendek agar sesuai batas MySQL.
            $table->unique(
                ['id_dokumen_pendukung', 'versi_ekstraksi'],
                'hei_dokumen_versi_unique'
            );

            $table->index(
                ['id_dokumen_pendukung', 'status_aktif'],
                'hei_dokumen_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_ekstraksi_informasi');
    }
};
