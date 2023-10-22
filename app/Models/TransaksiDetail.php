<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;
    protected $table = "transaksi_detail";
    protected $fillable = ["transaksi_id", "barang_id", "inventory_detail_id", "harga", "diskon_barang", "qty", "total_diskon", "total_harga"];
}
