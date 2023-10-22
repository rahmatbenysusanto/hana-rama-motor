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
        Schema::create('inbound_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('inbound_id');
            $table->integer('barang_id');
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('diskon');
            $table->integer('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_detail');
    }
};
