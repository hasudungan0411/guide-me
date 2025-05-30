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
        Schema::create('destinations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('latitude');
            $table->string('longitude');
            $table->string('tujuan');
            $table->text('gambar');
            $table->text('gambar2');
            $table->text('gambar3');
            $table->text('gambar4');
            $table->text('gambar5');
            $table->text('gambarM');
            $table->unsignedBigInteger('kategori_id')->nullable()->index('destinations_kategori_id_foreign');
            $table->text('desk');
            $table->text('long_desk');
            $table->integer('click_count')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
