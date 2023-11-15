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
        Schema::table('biaya_lainnya', function (Blueprint $table) {
            $table->integer('sales_id');
            $table->integer('nominal');
            $table->timestamp('tanggal');
            $table->text('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_lainnya', function (Blueprint $table) {
            $table->dropColumn('sales_id');
            $table->dropColumn('nominal');
            $table->dropColumn('tanggal');
            $table->dropColumn('keterangan');
        });
    }
};
