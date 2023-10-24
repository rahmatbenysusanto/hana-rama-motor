<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKhusus extends Model
{
    use HasFactory;
    protected $table = "transaksi_khusus";
    protected $fillable = ["sales_id", "no_transaksi_khusus", "jumlah_barang", "qty", "tanggal_pengambilan"];

    public function sales()
    {
        return $this->hasOne(Sales::class, 'id', 'sales_id');
    }
}
