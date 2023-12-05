<?php

namespace App\Http\Controllers;

use App\Models\Inbound;
use App\Models\InboundDetail;
use App\Models\Inventory;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());
        $jumlahPenjualan = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->count();
        // Stok Minimal Barang
        $stokMinimal = Inventory::with('barang')->orderBy('stok', 'ASC')->limit(12)->get();

        // Jumlah Tempo
        $totalTempo = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('tanggal_tempo', '!=', null)->count();

        // Jumlah Tempo
        $totalBelumDiBayar = Transaksi::WhereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->where('status_pembayaran', 'Belum DiBayar')->count();

        // Jumlah Pembelian
        $jumlahPembelian = Inbound::WhereMonth('tanggal_datang', $bulan)->whereYear('tanggal_datang', $tahun)->sum('qty_barang');
        $totalPembelian = Inbound::WhereMonth('tanggal_datang', $bulan)->whereYear('tanggal_datang', $tahun)->sum('total_harga');

        $transaksi = DB::table('transaksi')
            ->select([
                'transaksi.id as transaksi_id',
                'transaksi.no_invoice',
                'transaksi.diskon',
                'transaksi.tanggal_penjualan',
                'transaksi_detail.total_harga',
                'transaksi_detail.qty',
                'transaksi.tanggal_tempo',
                'transaksi.status_pembayaran',
                'transaksi.cicilan',
                'barang.id as barang_id',
                'barang.nama_barang',
                'barang.sku',
                'barang.kategori_id',
                'sales.nama as nama_sales',
                'pelanggan.nama as nama_pelanggan',
                'inventory_detail.harga'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->leftJoin('sales', 'sales.id', '=', 'transaksi.sales_id')
            ->leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->where('transaksi.status', 'penjualan')
            ->get();

        $totalPenjualan = 0;
        $pendapatanBersih = 0;
        $pendapatanKotor = 0;
        $totalPenjualanTempo = 0;

        $totalPenjualanBan = 0;
        $pendapatanBersihBan = 0;
        $pendapatanKotorBan = 0;
        $totalPenjualanTempoBan = 0;

        foreach ($transaksi as $tra) {
            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $pendapatanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $pendapatanKotor += $tra->cicilan;
            }

            $pendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        if (Session::get('pengaturanBarang') == 0) {
            foreach ($transaksi as $tra) {
                if ($tra->kategori_id == 2 ) {
                    $totalPenjualanBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

                    if ($tra->status_pembayaran == "Lunas") {
                        $pendapatanKotorBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    } else {
                        $totalPenjualanTempoBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    }

                    if ($tra->cicilan != null) {
                        $pendapatanKotorBan += $tra->cicilan;
                    }

                    $pendapatanBersihBan += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
                }

                if ($tra->barang_id == 28 || $tra->barang_id == 29 || $tra->barang_id == 30 || $tra->barang_id == 31) {
                    $totalPenjualanBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

                    if ($tra->status_pembayaran == "Lunas") {
                        $pendapatanKotorBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    } else {
                        $totalPenjualanTempoBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    }

                    if ($tra->cicilan != null) {
                        $pendapatanKotorBan += $tra->cicilan;
                    }

                    $pendapatanBersihBan += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
                }
            }

            $totalPenjualan = $totalPenjualan - $totalPenjualanBan;
            $pendapatanBersih = $pendapatanBersih - $pendapatanBersihBan;
            $pendapatanKotor = $pendapatanKotor - $pendapatanKotorBan;
            $totalPenjualanTempo = $totalPenjualanTempo - $totalPenjualanTempoBan;
        }

        $title = "dashboard utama";
        return view('dashboard.index', compact("title", "jumlahPenjualan", "totalPenjualanTempo", "pendapatanKotor", 'pendapatanBersih', 'stokMinimal', 'totalPenjualan', 'totalTempo', 'totalBelumDiBayar', 'totalPembelian', 'jumlahPembelian'));
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
                ->where('transaksi.status', 'penjualan')
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
                    ->where('transaksi.status', 'penjualan')
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
                ->where('transaksi.status', 'penjualan')
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
                    ->where('transaksi.status', 'penjualan')
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
                ->where('transaksi.status', 'penjualan')
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
                    ->where('transaksi.status', 'penjualan')
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

    public function oli(): View
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Stok Minimal Barang
        $stokMinimal = DB::table('inventory')
            ->select([
                'inventory.stok',
                'barang.nama_barang',
                'barang.sku',
                'barang.kategori_id'
            ])
            ->leftJoin('barang', 'barang.id', '=', 'inventory.barang_id')
            ->where('barang.kategori_id', 1)
            ->orderBy('inventory.stok', 'ASC')->limit(12)->get();

        $transaksi = DB::table('transaksi')
            ->select([
                'transaksi.id as transaksi_id',
                'transaksi.no_invoice',
                'transaksi.diskon',
                'transaksi.tanggal_penjualan',
                'transaksi_detail.total_harga',
                'transaksi_detail.qty',
                'transaksi.tanggal_tempo',
                'transaksi.status_pembayaran',
                'transaksi.cicilan',
                'barang.id as barang_id',
                'barang.nama_barang',
                'barang.sku',
                'barang.kategori_id',
                'sales.nama as nama_sales',
                'pelanggan.nama as nama_pelanggan',
                'inventory_detail.harga'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->leftJoin('sales', 'sales.id', '=', 'transaksi.sales_id')
            ->leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
            ->where('barang.kategori_id', 1)
            ->where('transaksi.status', 'penjualan')
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->get();

        $totalPenjualan = 0;
        $pendapatanBersih = 0;
        $pendapatanKotor = 0;
        $totalPenjualanTempo = 0;

        $totalPenjualanBan = 0;
        $pendapatanBersihBan = 0;
        $pendapatanKotorBan = 0;
        $totalPenjualanTempoBan = 0;

        foreach ($transaksi as $tra) {
            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $pendapatanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $pendapatanKotor += $tra->cicilan;
            }

            $pendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        if (Session::get('pengaturanBarang') == 0) {
            foreach ($transaksi as $tra) {
                if ($tra->kategori_id == 2 ) {
                    $totalPenjualanBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

                    if ($tra->status_pembayaran == "Lunas") {
                        $pendapatanKotorBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    } else {
                        $totalPenjualanTempoBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    }

                    if ($tra->cicilan != null) {
                        $pendapatanKotorBan += $tra->cicilan;
                    }

                    $pendapatanBersihBan += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
                }

                if ($tra->barang_id == 28 || $tra->barang_id == 29 || $tra->barang_id == 30 || $tra->barang_id == 31) {
                    $totalPenjualanBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

                    if ($tra->status_pembayaran == "Lunas") {
                        $pendapatanKotorBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    } else {
                        $totalPenjualanTempoBan += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
                    }

                    if ($tra->cicilan != null) {
                        $pendapatanKotorBan += $tra->cicilan;
                    }

                    $pendapatanBersihBan += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
                }
            }

            $totalPenjualan = $totalPenjualan - $totalPenjualanBan;
            $pendapatanBersih = $pendapatanBersih - $pendapatanBersihBan;
            $pendapatanKotor = $pendapatanKotor - $pendapatanKotorBan;
            $totalPenjualanTempo = $totalPenjualanTempo - $totalPenjualanTempoBan;
        }

        $title = "dashboard oli";
        return view('dashboard.dashboard_oli', compact('title', 'stokMinimal', 'pendapatanBersih', 'pendapatanKotor', 'totalPenjualan', 'totalPenjualanTempo'));
    }

    public function getDataOli(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Total Penjualan
        $totalPenjualan = 0;
        $jumlahTransaksiOli = 0;
        $totalPenjualanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;
        $dataTransaksi = DB::table('transaksi')
                            ->select([
                                'transaksi_detail.total_harga',
                                'transaksi.diskon',
                                'transaksi.id'
                            ])
                            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                            ->WhereMonth('tanggal_penjualan', $bulan)
                            ->whereYear('tanggal_penjualan', $tahun)
                            ->where('barang.kategori_id', 1)
                            ->where('transaksi.status', 'penjualan')
                            ->groupBy('transaksi.id')
                            ->get();

        foreach ($dataTransaksi as $transaksi) {
            // Jumlah Penjualan OLI
            $jumlahTransaksiOli++;

            // Total Penjualan
            $dataOli = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->where('transaksi.status', 'penjualan')
                ->where('transaksi.id', $transaksi->id);

            $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

            $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));

            // Jumlah Penjualan Bersih
            $dataPenjualanBersih = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->get();

            $dataPendapatanBersih = 0;
            foreach ($dataPenjualanBersih as $bersih) {
                $dataPendapatanBersih += $bersih->harga * $bersih->qty;
            }
            $totalPenjualanBersih += $dataPendapatanBersih;

            // Jumlah Penjualan Kotor
            $dataTotalPenjualanKotor = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $cariTotalPenjualanKotor = $dataTotalPenjualanKotor - ($dataTotalPenjualanKotor * ($transaksi->diskon / 100));
            $totalPenjualanKotor += $cariTotalPenjualanKotor;

            // Jumlah Penjualan Piutang
            $dataTotalPenjualanTempo = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->where('transaksi.id', $transaksi->id)
                ->where('tanggal_tempo', '!=', null)
                ->where('status_pembayaran', 'Belum DiBayar')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $totalPenjualanTempo += $dataTotalPenjualanTempo - ($dataTotalPenjualanTempo * ($transaksi->diskon / 100));
        }

        return response([
            'total_penjualan'   => $totalPenjualan,
            'penjualan_bersih'  => $totalPenjualanKotor - $totalPenjualanBersih,
            'penjualan_kotor'   => $totalPenjualanKotor,
            'penjualan_tempo'   => $totalPenjualanTempo,
            'jumlah_transaksi'  => $jumlahTransaksiOli
        ]);
    }

    public function getDataBan(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Total Penjualan
        $totalPenjualan = 0;
        $jumlahTransaksiOli = 0;
        $totalPenjualanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;
        $dataTransaksi = DB::table('transaksi')
            ->select([
                'transaksi_detail.total_harga',
                'transaksi.diskon',
                'transaksi.id'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->WhereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->where('barang.kategori_id', 2)
            ->where('transaksi.status', 'penjualan')
            ->groupBy('transaksi.id')
            ->get();

        foreach ($dataTransaksi as $transaksi) {
            // Jumlah Penjualan OLI
            $jumlahTransaksiOli++;

            // Total Penjualan
            $dataOli = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->where('transaksi.status', 'penjualan')
                ->where('transaksi.id', $transaksi->id);

            $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

            $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));

            // Jumlah Penjualan Bersih
            $dataPenjualanBersih = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->get();

            $dataPendapatanBersih = 0;
            foreach ($dataPenjualanBersih as $bersih) {
                $dataPendapatanBersih += $bersih->harga * $bersih->qty;
            }
            $totalPenjualanBersih += $dataPendapatanBersih;

            // Jumlah Penjualan Kotor
            $dataTotalPenjualanKotor = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $cariTotalPenjualanKotor = $dataTotalPenjualanKotor - ($dataTotalPenjualanKotor * ($transaksi->diskon / 100));
            $totalPenjualanKotor += $cariTotalPenjualanKotor;

            // Jumlah Penjualan Piutang
            $dataTotalPenjualanTempo = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->where('transaksi.id', $transaksi->id)
                ->where('tanggal_tempo', '!=', null)
                ->where('status_pembayaran', 'Belum DiBayar')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $totalPenjualanTempo += $dataTotalPenjualanTempo - ($dataTotalPenjualanTempo * ($transaksi->diskon / 100));
        }

        return response([
            'total_penjualan'   => $totalPenjualan,
            'penjualan_bersih'  => $totalPenjualanKotor - $totalPenjualanBersih,
            'penjualan_kotor'   => $totalPenjualanKotor,
            'penjualan_tempo'   => $totalPenjualanTempo,
            'jumlah_transaksi'  => $jumlahTransaksiOli
        ]);
    }

    public function getDataSparepart(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Total Penjualan
        $totalPenjualan = 0;
        $jumlahTransaksiOli = 0;
        $totalPenjualanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;
        $dataTransaksi = DB::table('transaksi')
            ->select([
                'transaksi_detail.total_harga',
                'transaksi.diskon',
                'transaksi.id'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->WhereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->where('barang.kategori_id', 3)
            ->where('transaksi.status', 'penjualan')
            ->groupBy('transaksi.id')
            ->get();

        foreach ($dataTransaksi as $transaksi) {
            // Jumlah Penjualan OLI
            $jumlahTransaksiOli++;

            // Total Penjualan
            $dataOli = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->where('transaksi.status', 'penjualan')
                ->where('transaksi.id', $transaksi->id);

            $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

            $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));

            // Jumlah Penjualan Bersih
            $dataPenjualanBersih = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->get();

            $dataPendapatanBersih = 0;
            foreach ($dataPenjualanBersih as $bersih) {
                $dataPendapatanBersih += $bersih->harga * $bersih->qty;
            }
            $totalPenjualanBersih += $dataPendapatanBersih;

            // Jumlah Penjualan Kotor
            $dataTotalPenjualanKotor = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->where('transaksi.id', $transaksi->id)
                ->where('status_pembayaran', 'Lunas')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $cariTotalPenjualanKotor = $dataTotalPenjualanKotor - ($dataTotalPenjualanKotor * ($transaksi->diskon / 100));
            $totalPenjualanKotor += $cariTotalPenjualanKotor;

            // Jumlah Penjualan Piutang
            $dataTotalPenjualanTempo = DB::table('transaksi')
                ->select([
                    'inventory_detail.harga',
                    'transaksi_detail.barang_id',
                    'transaksi_detail.total_harga',
                    'transaksi_detail.qty'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->where('transaksi.id', $transaksi->id)
                ->where('tanggal_tempo', '!=', null)
                ->where('status_pembayaran', 'Belum DiBayar')
                ->where('transaksi.status', 'penjualan')
                ->sum('transaksi_detail.total_harga');

            $totalPenjualanTempo += $dataTotalPenjualanTempo - ($dataTotalPenjualanTempo * ($transaksi->diskon / 100));
        }

        return response([
            'total_penjualan'   => $totalPenjualan,
            'penjualan_bersih'  => $totalPenjualanKotor - $totalPenjualanBersih,
            'penjualan_kotor'   => $totalPenjualanKotor,
            'penjualan_tempo'   => $totalPenjualanTempo,
            'jumlah_transaksi'  => $jumlahTransaksiOli
        ]);
    }

    public function ban(): View
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Stok Minimal Barang
        $stokMinimal = DB::table('inventory')
            ->select([
                'inventory.stok',
                'barang.nama_barang',
                'barang.sku',
                'barang.kategori_id'
            ])
            ->leftJoin('barang', 'barang.id', '=', 'inventory.barang_id')
            ->where('barang.kategori_id', 2)
            ->orderBy('inventory.stok', 'ASC')->limit(12)->get();

        $transaksi = DB::table('transaksi')
            ->select([
                'transaksi.id as transaksi_id',
                'transaksi.no_invoice',
                'transaksi.diskon',
                'transaksi.tanggal_penjualan',
                'transaksi_detail.total_harga',
                'transaksi_detail.qty',
                'transaksi.tanggal_tempo',
                'transaksi.status_pembayaran',
                'transaksi.cicilan',
                'barang.nama_barang',
                'barang.sku',
                'sales.nama as nama_sales',
                'pelanggan.nama as nama_pelanggan',
                'inventory_detail.harga'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->leftJoin('sales', 'sales.id', '=', 'transaksi.sales_id')
            ->leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
            ->where('barang.kategori_id', 2)
            ->where('transaksi.status', 'penjualan')
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->get();

        $totalPenjualan = 0;
        $pendapatanBersih = 0;
        $pendapatanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $pendapatanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $pendapatanKotor += $tra->cicilan;
            }

            $pendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "dashboard ban";
        return view('dashboard.dashboard_ban', compact('title', 'stokMinimal', 'pendapatanBersih', 'pendapatanKotor', 'totalPenjualan', 'totalPenjualanTempo'));
    }

    public function sparepart(): View
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        // Stok Minimal Barang
        $stokMinimal = DB::table('inventory')
            ->select([
                'inventory.stok',
                'barang.nama_barang',
                'barang.sku',
                'barang.kategori_id'
            ])
            ->leftJoin('barang', 'barang.id', '=', 'inventory.barang_id')
            ->where('barang.kategori_id', 3)
            ->orderBy('inventory.stok', 'ASC')->limit(12)->get();

        $transaksi = DB::table('transaksi')
            ->select([
                'transaksi.id as transaksi_id',
                'transaksi.no_invoice',
                'transaksi.diskon',
                'transaksi.tanggal_penjualan',
                'transaksi_detail.total_harga',
                'transaksi_detail.qty',
                'transaksi.tanggal_tempo',
                'transaksi.status_pembayaran',
                'transaksi.cicilan',
                'barang.nama_barang',
                'barang.sku',
                'sales.nama as nama_sales',
                'pelanggan.nama as nama_pelanggan',
                'inventory_detail.harga'
            ])
            ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->leftJoin('sales', 'sales.id', '=', 'transaksi.sales_id')
            ->leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
            ->where('barang.kategori_id', 3)
            ->where('transaksi.status', 'penjualan')
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->get();

        $totalPenjualan = 0;
        $pendapatanBersih = 0;
        $pendapatanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $pendapatanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $pendapatanKotor += $tra->cicilan;
            }

            $pendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "dashboard oli";
        return view('dashboard.dashboard_oli', compact('title', 'stokMinimal', 'pendapatanBersih', 'pendapatanKotor', 'totalPenjualan', 'totalPenjualanTempo'));
    }

    public function chart_oli()
    {
        $tahun = date('Y', time());
        $penjualan = [];
        for ($a = 1; $a <= 12; $a++) {
            $dataTransaksi = DB::table('transaksi')
                ->select([
                    'transaksi_detail.total_harga',
                    'transaksi.diskon',
                    'transaksi.id'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 1)
                ->where('transaksi.status', 'penjualan')
                ->groupBy('transaksi.id')
                ->get();

            $totalPenjualan = 0;
            foreach ($dataTransaksi as $transaksi) {
                // Total Penjualan
                $dataOli = DB::table('transaksi')
                    ->select([
                        'inventory_detail.harga',
                        'transaksi_detail.barang_id',
                        'transaksi_detail.total_harga',
                        'transaksi_detail.qty'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 1)
                    ->where('transaksi.status', 'penjualan')
                    ->where('transaksi.id', $transaksi->id);

                $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

                $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));
            }
            $penjualan[] = $totalPenjualan;
        }

        return response([
           'penjualan'  => $penjualan
        ]);
    }

    public function chart_ban()
    {
        $tahun = date('Y', time());
        $penjualan = [];
        for ($a = 1; $a <= 12; $a++) {
            $dataTransaksi = DB::table('transaksi')
                ->select([
                    'transaksi_detail.total_harga',
                    'transaksi.diskon',
                    'transaksi.id'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 2)
                ->where('transaksi.status', 'penjualan')
                ->groupBy('transaksi.id')
                ->get();

            $totalPenjualan = 0;
            foreach ($dataTransaksi as $transaksi) {
                // Total Penjualan
                $dataOli = DB::table('transaksi')
                    ->select([
                        'inventory_detail.harga',
                        'transaksi_detail.barang_id',
                        'transaksi_detail.total_harga',
                        'transaksi_detail.qty'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 2)
                    ->where('transaksi.status', 'penjualan')
                    ->where('transaksi.id', $transaksi->id);

                $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

                $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));
            }
            $penjualan[] = $totalPenjualan;
        }

        return response([
            'penjualan'  => $penjualan
        ]);
    }

    public function chart_sparepart()
    {
        $tahun = date('Y', time());
        $penjualan = [];
        for ($a = 1; $a <= 12; $a++) {
            $dataTransaksi = DB::table('transaksi')
                ->select([
                    'transaksi_detail.total_harga',
                    'transaksi.diskon',
                    'transaksi.id'
                ])
                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                ->WhereMonth('tanggal_penjualan', $a)
                ->whereYear('tanggal_penjualan', $tahun)
                ->where('barang.kategori_id', 3)
                ->where('transaksi.status', 'penjualan')
                ->groupBy('transaksi.id')
                ->get();

            $totalPenjualan = 0;
            foreach ($dataTransaksi as $transaksi) {
                // Total Penjualan
                $dataOli = DB::table('transaksi')
                    ->select([
                        'inventory_detail.harga',
                        'transaksi_detail.barang_id',
                        'transaksi_detail.total_harga',
                        'transaksi_detail.qty'
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('inventory_detail', 'inventory_detail.id', '=', 'transaksi_detail.inventory_detail_id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->WhereMonth('tanggal_penjualan', $a)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('barang.kategori_id', 3)
                    ->where('transaksi.status', 'penjualan')
                    ->where('transaksi.id', $transaksi->id);

                $dataTotalPenjualan = $dataOli->sum('transaksi_detail.total_harga');

                $totalPenjualan += $dataTotalPenjualan - ($dataTotalPenjualan * ($transaksi->diskon / 100));
            }
            $penjualan[] = $totalPenjualan;
        }

        return response([
            'penjualan'  => $penjualan
        ]);
    }
}
