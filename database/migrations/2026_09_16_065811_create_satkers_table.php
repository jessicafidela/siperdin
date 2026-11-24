<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satuan_kerja', function (Blueprint $table) {
            $table->increments('id_satker');
            $table->string('kode_satker', 30)->unique();
            $table->string('nama_satker', 100);
            $table->text('keterangan')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satuan_kerja');
    }
};
