<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tempat', function (Blueprint $table) {
            $table->increments('id_tempat');
            $table->string('nama_tempat', 100);
            $table->string('jenis_tempat', 50)->nullable();
            $table->string('wilayah', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status', 20)->default('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tempat');
    }
};
