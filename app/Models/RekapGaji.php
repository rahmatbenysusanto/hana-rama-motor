<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapGaji extends Model
{
    use HasFactory;
    protected $table = "rekap_gaji";
    protected $fillable = ["sales_id", "gaji_pokok", "uang_makan", "uang_bensin", "sewa_kendaraan", "operasional", "kas_bon", "potongan", "total_penjualan", "bonus_penjualan", "gaji_bersih", "keterangan", "tanggal"];
}
