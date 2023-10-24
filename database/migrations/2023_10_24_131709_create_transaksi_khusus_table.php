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
        Schema::create('transaksi_khusus', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_id');
            $table->string('no_transaksi_khusus');
            $table->integer('jumlah_barang');
            $table->integer('qty');
            $table->timestamp('tanggal_pengambilan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_khusus');
    }
};
