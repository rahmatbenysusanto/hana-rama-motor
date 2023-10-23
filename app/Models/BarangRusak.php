<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    use HasFactory;
    protected $table = "barang_rusak";
    protected $fillable = ["barang_id", "supplier_id", "stok"];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
