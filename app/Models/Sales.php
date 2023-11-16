<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = "sales";
    protected $fillable = ["status", "nama", "no_hp", "type", "nominal", "target", "gaji_pokok", "uang_bensin", "uang_makan", "sewa_kendaraan"];
}
