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
        Schema::create('wisatawan', function (Blueprint $table) {
            $table->integer('ID_Wisatawan', true);
            $table->string('Nama');
            $table->string('Email');
            $table->string('Kata_Sandi');
            $table->string('Nomor_HP', 15);
            $table->string('Foto_Profil')->nullable();
            $table->date('email_verified_at')->nullable();
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisatawan');
    }
};
