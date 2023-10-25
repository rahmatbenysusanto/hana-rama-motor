<?php

namespace App\services;

use App\Models\TrackingStok;

class TrackingStokService
{
    public function trackingStok($inventory_id, $inbound_id, $inbound_detail_id, $transaksi_id, $transaksi_detail_id, $sampel_id, $sampel_detail_id, $qty, $from, $to, $ket)
    {
        TrackingStok::create([
            'inventory_id'          => $inventory_id,
            'inbound_id'            => $inbound_id,
            'inbound_detail_id'     => $inbound_detail_id,
            'transaksi_id'          => $transaksi_id,
            'transaksi_detail_id'   => $transaksi_detail_id,
            'sampel_id'             => $sampel_id,
            'sampel_detail_id'      => $sampel_detail_id,
            'qty'                   => $qty,
            'from'                  => $from,
            'to'                    => $to,
            'keterangan'            => $ket
        ]);
    }
}
