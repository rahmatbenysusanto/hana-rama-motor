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
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('uang_makan')->nullable()->after('gaji_pokok');
            $table->integer('uang_bensin')->nullable()->after('uang_makan');
            $table->integer('sewa_kendaraan')->nullable()->after('uang_bensin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('uang_makan');
            $table->dropColumn('uang_bensin');
            $table->dropColumn('sewa_kendaraan');
        });
    }
};
