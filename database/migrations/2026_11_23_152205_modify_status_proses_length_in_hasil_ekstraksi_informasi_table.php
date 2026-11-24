<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hasil_ekstraksi_informasi', function (Blueprint $table) {
            $table->string('status_proses', 20)
                ->default('menunggu')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ekstraksi_informasi', function (Blueprint $table) {
            $table->string('status_proses', 30)
                ->default('menunggu')
                ->change();
        });
    }
};
