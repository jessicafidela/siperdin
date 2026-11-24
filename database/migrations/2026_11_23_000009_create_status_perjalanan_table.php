<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_perjalanan', function (Blueprint $table) {
            $table->increments('id_status');
            $table->unsignedInteger('id_perjalanan');
            $table->string('status', 50);
            // Dipertahankan sesuai spesifikasi tabel dan alur pengembalian pada Bab V.
            $table->text('catatan_perbaikan')->nullable();
            $table->dateTime('waktu_perubahan');
            $table->unsignedInteger('id_user');

            $table->foreign('id_perjalanan')
                ->references('id_perjalanan')->on('perjalanan_dinas')
                ->restrictOnDelete();
            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->restrictOnDelete();

            $table->index(['id_perjalanan', 'waktu_perubahan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_perjalanan');
    }
};
