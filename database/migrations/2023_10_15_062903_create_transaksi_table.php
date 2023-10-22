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
            $table->id();
            $table->integer('pelanggan_id');
            $table->integer('sales_id');
            $table->integer('diskon');
            $table->integer('pembayaran_id');
            $table->string('no_invoice');
            $table->integer('harga_diskon')->nullable();
            $table->integer('biaya_lain')->nullable();
            $table->integer('total_harga');
            $table->string('status');
            $table->timestamp('tanggal_penjualan')->nullable();
            $table->timestamp('tanggal_tempo')->nullable();
            $table->timestamps();
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
