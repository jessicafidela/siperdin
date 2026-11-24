<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // PDM: users.id_user (INT). Password column follows Laravel convention.
            $table->increments('id_user');
            $table->unsignedInteger('id_pegawai')->nullable()->unique();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('status', 20)->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
