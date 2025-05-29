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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->integer('ID_Ulasan', true);
            $table->integer('destinations_id'); // Tipe data harus unsignedInteger untuk foreign key ke destinations
            $table->integer('wisatawan_id'); // Tipe data harus integer untuk foreign key ke wisatawan
            $table->text('ulasan'); // Kolom untuk ulasan
            $table->integer('rating'); // Misalnya rating (nilai dari 1-5)
            $table->timestamps(); // created_at, updated_at

            // Menambahkan foreign key untuk destinations_id
            $table->foreign('destinations_id')->references('id')->on('destinations')->onDelete('cascade');

            // Menambahkan foreign key untuk wisatawan_id
            $table->foreign('wisatawan_id')->references('ID_Wisatawan')->on('wisatawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
