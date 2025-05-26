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
        Schema::create('pemilik_wisata', function (Blueprint $table) {
            $table->integer('ID_Pemilik_Wisata', true);
            $table->string('Email', 100);
            $table->string('Kata_Sandi');
            $table->string('Nomor_HP');
            $table->string('Nama_Wisata', 100)->nullable();
            $table->string('Lokasi');
            $table->date('email_verified_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilik_wisata');
    }
};
