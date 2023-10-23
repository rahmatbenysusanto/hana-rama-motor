<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStokBarangRusak extends Model
{
    use HasFactory;
    protected $table = "tracking_stok_barang_rusak";
    protected $fillable = ["barang_id", "transaksi_id", "transaksi_detail_id", "sampel_id", "sampel_detail_id", "qty", "from", "to", "keterangan"];
}
