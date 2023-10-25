<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = "transaksi";
    protected $fillable = ["pelanggan_id", "sales_id", "diskon", "pembayaran_id", "no_invoice", "harga_diskon", "biaya_lain", "total_harga", "status", "tanggal_penjualan", "tanggal_tempo", "jumlah_barang", "qty", "status_pembayaran"];

    public function sales(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Sales::class, 'id', 'sales_id');
    }

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id');
    }

    public function pembayaran(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id', 'pembayaran_id');
    }
}
