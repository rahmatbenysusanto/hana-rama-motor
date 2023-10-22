<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundDetail extends Model
{
    use HasFactory;
    protected $table = "inbound_detail";
    protected $fillable = ["inbound_id", "barang_id", "qty", "harga", "diskon", "total_harga"];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id', 'barang_id');
    }
}
