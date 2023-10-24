<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKhususDetail extends Model
{
    use HasFactory;
    protected $table = "transaksi_khusus_detail";
    protected $fillable = ["transaksi_khusus_id", "barang_id", "qty", "status", "qty_kembali"];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
