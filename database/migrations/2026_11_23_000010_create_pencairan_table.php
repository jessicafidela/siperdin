<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencairan', function (Blueprint $table) {
            $table->increments('id_pencairan');
            $table->unsignedInteger('id_perjalanan')->unique();
            $table->string('nomor_pencairan', 50)->nullable()->unique();
            $table->date('tanggal_pencairan')->nullable();
            $table->decimal('jumlah_pencairan', 15, 2);
            $table->string('status_pencairan', 30)->default('menunggu');
            $table->string('bukti_pencairan', 255)->nullable();

            $table->foreign('id_perjalanan')
                ->references('id_perjalanan')->on('perjalanan_dinas')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencairan');
    }
};
