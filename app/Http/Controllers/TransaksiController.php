<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Sales;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function buat_transaksi(): View
    {
        $dataPelanggan = Pelanggan::all();
        $dataSales = Sales::all();
        $dataBarang = Barang::all();
        $dataPembayaran = Pembayaran::all();

        $pelanggan = $dataPelanggan ?? [];
        $sales = $dataSales ?? [];
        $barang  = $dataBarang ?? [];
        $pembayaran = $dataPembayaran ?? [];

        $title = "buat transaksi";
        return view('outbound.buat_transaksi', compact('title', 'pelanggan', 'sales', 'barang', 'pembayaran'));
    }

    public function buat_transaksi_post(Request $request)
    {
        try {
            DB::beginTransaction();
                $transaksi = Transaksi::create([

                ]);

            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
        }
    }
}
