<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampelDetail extends Model
{
    use HasFactory;
    protected $table = "sampel_detail";
    protected $fillable = ["sampel_id", "barang_id", "inventory_detail_id", "qty", "harga", "total_harga"];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
