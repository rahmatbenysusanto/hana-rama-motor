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
        Schema::create('inbound', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('po_number');
            $table->text('no_invoice')->nullable();
            $table->integer('jumlah_barang');
            $table->integer('qty_barang');
            $table->timestamp('tanggal_datang');
            $table->integer('diskon_pembelian');
            $table->integer('ppn');
            $table->integer('total_harga');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound');
    }
};
