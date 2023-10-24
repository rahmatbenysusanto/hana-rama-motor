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
        Schema::create('transaksi_khusus_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_khusus_id');
            $table->integer('barang_id');
            $table->integer('qty');
            $table->string('status');
            $table->integer('qty_kembali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_khusus_detail');
    }
};
