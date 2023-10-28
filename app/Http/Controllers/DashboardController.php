<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $bulan = date('m', time());
        $jumlahPenjualan = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->count();
        $totalPiutang = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->where('tanggal_tempo', '!=', null)->where('status_pembayaran', 'Belum DiBayar')->sum('total_harga');
        $pendapatanKotor = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->where('status_pembayaran', 'Lunas')->sum('total_harga');
        $dataTransaksi = DB::table('transaksi')
                            ->select([
                                'transaksi.total_harga',
                                'transaksi_detail.qty',
                                'inventory_detail.harga'
                            ])
                            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id','=', 'transaksi.id')
                            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                            ->whereMonth('tanggal_penjualan', $bulan)
                            ->where('status_pembayaran', 'Lunas')
                            ->get();

        $dataPendapatanBersih = 0;
        foreach ($dataTransaksi as $detail) {
            $dataPendapatanBersih += $detail->harga * $detail->qty;
        }

        $pendapatanBersih = $pendapatanKotor - $dataPendapatanBersih;

        // Stok Minimal Barang
        $stokMinimal = Inventory::with('barang')->orderBy('stok', 'ASC')->limit(12)->get();

        $title = "dashboard utama";
        return view('dashboard.index', compact("title", "jumlahPenjualan", "totalPiutang", "pendapatanKotor", 'pendapatanBersih', 'stokMinimal'));
    }
}
