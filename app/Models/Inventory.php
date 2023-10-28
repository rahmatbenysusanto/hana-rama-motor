<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "inventory";
    protected $fillable = ["barang_id", "stok"];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
