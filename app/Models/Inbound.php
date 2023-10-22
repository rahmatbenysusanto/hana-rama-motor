<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    use HasFactory;
    protected $table = "inbound";
    protected $fillable = ["supplier_id", "kategori_id", "po_number", "no_invoice", "jumlah_barang", "qty_barang", "tanggal_datang", "total_harga", "diskon_pembelian", "ppn". "type"];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function inboundDetail()
    {
        return $this->hasMany(InboundDetail::class, 'inbound_id', 'id');
    }
}
