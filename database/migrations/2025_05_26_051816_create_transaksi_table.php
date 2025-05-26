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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->integer('ID_Transaksi', true);
            $table->string('ID_Tiket');
            $table->integer('ID_Wisata');
            $table->integer('ID_Wisatawan');
            $table->enum('Status', ['Unpaid', 'Paid']);
            $table->integer('total_harga');
            $table->integer('Jumlah_Tiket');
            $table->date('Tanggal_Transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
