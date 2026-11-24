<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_perjalanan_dinas', function (Blueprint $table) {
            $table->increments('id_biaya');
            $table->unsignedInteger('id_detail');
            $table->unsignedInteger('id_sbm')->nullable();
            $table->string('jenis_biaya', 50);
            $table->unsignedInteger('jumlah');
            $table->decimal('nilai_satuan', 15, 2);
            $table->decimal('total_biaya', 15, 2);
            $table->timestamps();

            $table->foreign('id_detail')
                ->references('id_detail')->on('detail_perjalanan_dinas')
                ->restrictOnDelete();
            $table->foreign('id_sbm')
                ->references('id_sbm')->on('standar_biaya_masukan')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_perjalanan_dinas');
    }
};
