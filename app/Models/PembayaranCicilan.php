<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranCicilan extends Model
{
    use HasFactory;
    protected $table = "pembayaran_cicilan";
    protected $fillable = ["transaksi_id", "jumlah", "tanggal"];
}
