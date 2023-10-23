<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStok extends Model
{
    use HasFactory;
    protected $table = "tracking_stok";
    protected $fillable = ["inventory_id", "inbound_id", "inbound_detail_id", "transaksi_id", "transaksi_detail_id", "sampel_id", "sampel_detail_id", "qty", "from", "to", "keterangan"];
}
