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
        $tahun = date('Y', time());
        $jumlahPenjualan = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->count();
        $totalPiutang = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('tanggal_tempo', '!=', null)->where('status_pembayaran', 'Belum DiBayar')->sum('total_harga');
        $pendapatanKotor = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('status_pembayaran', 'Lunas')->sum('total_harga');
        $dataTransaksi = DB::table('transaksi')
                            ->select([
                                'transaksi.total_harga',
                                'transaksi_detail.qty',
                                'inventory_detail.harga'
                            ])
                            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id','=', 'transaksi.id')
                            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                            ->whereMonth('tanggal_penjualan', $bulan)
                            ->whereYear('tanggal_penjualan', $tahun)
                            ->where('status_pembayaran', 'Lunas')
                            ->get();

        $dataPendapatanBersih = 0;
        foreach ($dataTransaksi as $detail) {
            $dataPendapatanBersih += $detail->harga * $detail->qty;
        }

        $pendapatanBersih = $pendapatanKotor - $dataPendapatanBersih;

        // Stok Minimal Barang
        $stokMinimal = Inventory::with('barang')->orderBy('stok', 'ASC')->limit(12)->get();

        // Total Semua Penjualan
        $totalPenjualan = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->sum('total_harga');

        // Jumlah Tempo
        $totalTempo = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('tanggal_tempo', '!=', null)->count();

        // Jumlah Tempo
        $totalBelumDiBayar = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('status_pembayaran', 'Belum DiBayar')->count();

        $title = "dashboard utama";
        return view('dashboard.index', compact("title", "jumlahPenjualan", "totalPiutang", "pendapatanKotor", 'pendapatanBersih', 'stokMinimal', 'totalPenjualan', 'totalTempo', 'totalBelumDiBayar'));
    }

    public function dashboardChartTotalPenjualan(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        // Data Chart Penjualan
        $bulan = date('m', time());
        $tahun = date('Y', time());

        $dataPenjualanOli = [];
        $dataPenjualanBan = [];
        $dataPenjualanSparepart = [];

        for ($a = 1; $a <= 12; $a++) {
            // Data Oli
            $dataTransaksiOli = DB::table('transaksi')
                ->select([
                    'transaksi.id',
                    'transaksi.diskon',
                    'transaksi_detail.total_harga'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->groupBy('transaksi.id')
                ->get();

            $totalOli = 0;
            foreach ($dataTransaksiOli as $oli) {
                $dataOli = DB::table('transaksi')
                    ->select([
                        'transaksi_detail.total_harga'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 1)
                    ->where('transaksi.id', $oli->id)
                    ->sum('transaksi_detail.total_harga');

                $totalOli += $dataOli - ($dataOli * ($oli->diskon / 100));
            }
            $dataPenjualanOli[] = $totalOli;

            // Data Ban
            $dataTransaksiBan = DB::table('transaksi')
                ->select([
                    'transaksi.id',
                    'transaksi.diskon',
                    'transaksi_detail.total_harga'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->groupBy('transaksi.id')
                ->get();

            $totalBan = 0;
            foreach ($dataTransaksiBan as $ban) {
                $dataBan = DB::table('transaksi')
                    ->select([
                        'transaksi_detail.total_harga'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 2)
                    ->where('transaksi.id', $ban->id)
                    ->sum('transaksi_detail.total_harga');

                $totalBan += $dataBan - ($dataBan * ($ban->diskon / 100));
            }
            $dataPenjualanBan[] = $totalBan;

            // Data Sparepart
            $dataTransaksiSparepart = DB::table('transaksi')
                ->select([
                    'transaksi.id',
                    'transaksi.diskon',
                    'transaksi_detail.total_harga'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->groupBy('transaksi.id')
                ->get();

            $totalSparepart = 0;
            foreach ($dataTransaksiSparepart as $spar) {
                $dataSparepart = DB::table('transaksi')
                    ->select([
                        'transaksi_detail.total_harga'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 3)
                    ->where('transaksi.id', $spar->id)
                    ->sum('transaksi_detail.total_harga');

                $totalSparepart += $dataSparepart - ($dataSparepart * ($spar->diskon / 100));
            }
            $dataPenjualanSparepart[] = $totalSparepart;
        }

        return response([
            'oli'       => $dataPenjualanOli,
            'ban'       => $dataPenjualanBan,
            'sparepart' => $dataPenjualanSparepart
        ]);
    }
}
