<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barang";
    protected $fillable = ["sku", "nama_barang", "harga_sales", "harga_umum", "kategori_id", "delete"];

    public function inventory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function kategori(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kategori::class, 'id', 'kategori_id');
    }
}
