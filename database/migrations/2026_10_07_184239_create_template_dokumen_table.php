<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_dokumen', function (Blueprint $table) {
            $table->increments('id_template');
            $table->string('nama_template', 100);
            $table->string('jenis_dokumen', 50);
            $table->string('format_file', 20)->nullable();
            $table->text('struktur_dokumen')->nullable();
            $table->text('aturan_penomoran')->nullable();
            $table->string('lokasi_template', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_dokumen');
    }
};
