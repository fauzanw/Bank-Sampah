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
        Schema::create('transaksi_sampah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_sampah_id');
            $table->integer('jumlah_kilogram');
            $table->integer('total_harga');
            $table->string('waktu_penerimaan');
            $table->timestamps();

            $table->foreign('jenis_sampah_id')->references('id')->on('jenis_sampah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampahs');
    }
};
