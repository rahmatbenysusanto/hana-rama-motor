<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaLainnya extends Model
{
    use HasFactory;
    protected $table = "biaya_lainnya";
    protected $fillable = ["sales_id", "nominal", "keterangan", "tanggal"];

    public function sales(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Sales::class, 'id', 'sales_id');
    }
}
