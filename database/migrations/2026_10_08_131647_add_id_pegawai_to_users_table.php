<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom id_pegawai sudah dibuat pada migration users agar sesuai PDM.
        // Migration ini hanya menambahkan FK setelah tabel pegawai tersedia.
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_pegawai')
                ->references('id_pegawai')->on('pegawai')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_pegawai']);
        });
    }
};
