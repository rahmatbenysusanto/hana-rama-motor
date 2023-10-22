<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    use HasFactory;
    protected $table = "inventory_detail";
    protected $fillable = ["inventory_id", "harga", "qty"];
}
