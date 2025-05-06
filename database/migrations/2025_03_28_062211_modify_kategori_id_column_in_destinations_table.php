<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah nama kolom 'kategori' jadi 'kategori_id' dan ubah ke BIGINT UNSIGNED
        DB::statement('ALTER TABLE destinations CHANGE COLUMN kategori kategori_id BIGINT UNSIGNED');

        // 2. Ubah tipe kolom 'id_kategori' di tabel kategori jadi BIGINT UNSIGNED juga
        DB::statement('ALTER TABLE kategori MODIFY COLUMN id_kategori BIGINT UNSIGNED AUTO_INCREMENT');

        // 3. Tambahkan foreign key dari destinations.kategori_id ke kategori.id_kategori
        Schema::table('destinations', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Balikin kalau rollback
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
        });

        DB::statement('ALTER TABLE destinations CHANGE COLUMN kategori_id kategori VARCHAR(255)');
        DB::statement('ALTER TABLE kategori MODIFY COLUMN id_kategori INT UNSIGNED AUTO_INCREMENT');
    }
};
