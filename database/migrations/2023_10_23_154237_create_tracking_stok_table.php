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
        Schema::create('tracking_stok', function (Blueprint $table) {
            $table->id();
            $table->integer('inventory_id')->nullable();
            $table->integer('inbound_id')->nullable();
            $table->integer('inbound_detail_id')->nullable();
            $table->integer('transaksi_id')->nullable();
            $table->integer('transaksi_detail_id')->nullable();
            $table->integer('sampel_id')->nullable();
            $table->integer('sampel_detail_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_stok');
    }
};
