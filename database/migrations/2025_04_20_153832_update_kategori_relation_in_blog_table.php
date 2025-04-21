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
        Schema::table('blog', function (Blueprint $table) {
            // ubah kolom kategori 
            $table->unsignedBigInteger('kategori_id')->change();

            // tambahkan relasinya 
            $table->foreign('kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            // Optional: ubah balik ke string kalau sebelumnya begitu
            $table->string('kategori')->change();
        });
    }
};
