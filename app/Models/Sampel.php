<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampel extends Model
{
    use HasFactory;
    protected $table = "sampel";
    protected $fillable = ["sales_id", "no_sampel", "jumlah_barang", "qty", "status"];
}
