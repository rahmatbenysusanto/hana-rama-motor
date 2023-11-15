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
        Schema::create('rekap_gaji', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_id');
            $table->integer('gaji_pokok');
            $table->integer('uang_makan');
            $table->integer('uang_bensin');
            $table->integer('sewa_kendaraan');
            $table->integer('operasional');
            $table->integer('kas_bon');
            $table->integer('total_penjualan');
            $table->integer('bonus_penjualan');
            $table->integer('gaji_bersih');
            $table->text('keterangan');
            $table->timestamp('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_gaji');
    }
};
