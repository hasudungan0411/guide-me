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
        Schema::create('acara', function (Blueprint $table) {
            $table->integer('ID_Acara', true);
            $table->integer('ID_Wisata')->index('fk_destination_id');
            $table->date('Tanggal_mulai_acara');
            $table->date('Tanggal_berakhir_acara');
            $table->string('Nama_acara');
            $table->text('Deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acara');
    }
};
