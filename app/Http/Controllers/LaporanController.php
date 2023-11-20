<?php

namespace App\Http\Controllers;

use App\Models\RekapGaji;
use App\Models\Sales;
use App\Models\Transaksi;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function laporan_transaksi():View
    {
        $dataSales = Sales::all();

        $sales = $dataSales ?? [];

        $title = "laporan transaksi";
        return view('laporan.list_sales', compact('title', 'sales'));
    }

    public function laporan_sales($id): View
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        $dataSales = Sales::where('id', $id)->first();

        $sales = $dataSales ?? [];

        // Total Pendapatan Sales
        $totalPenjualan = Transaksi::where('sales_id', $id)->whereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->sum('total_harga');

        // Jumlah Transaksi
        $jumlahTransaksi = Transaksi::where('sales_id', $id)->whereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->count();

        // Piutang
        $piutang = Transaksi::where('sales_id', $id)
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->where('tanggal_tempo', '!=', null)
            ->where('status_pembayaran', 'Belum DiBayar')
            ->sum('total_harga');

        // List Transaksi
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')
            ->where('sales_id', $id)
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->orderBy('tanggal_penjualan', 'DESC')
            ->get();

        $transaksi = $dataTransaksi ?? [];

        // Pendapatan Bersih
        $transaksi2 = DB::table('transaksi')
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
            ->where('transaksi.sales_id', $id)
            ->whereMonth('transaksi.tanggal_penjualan', $bulan)
            ->whereYear('transaksi.tanggal_penjualan', $tahun)
            ->get();

        $totalPendapatanBersih = 0;
        foreach ($transaksi2 as $tra) {
            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $waktu = tanggal_format(date('Y-m-d', time()));

        $title = "laporan transaksi";
        return view('laporan.laporan_sales', compact('title', 'sales', 'totalPenjualan', 'jumlahTransaksi', 'piutang', 'transaksi', 'waktu', 'totalPendapatanBersih'));
    }

    public function laporan_sales_tanggal(Request $request)
    {
        $dataSales = Sales::where('id', $request->sales_id)->first();

        $sales = $dataSales ?? [];

        // Total Pendapatan Sales
        $totalPenjualan = Transaksi::where('sales_id', $request->sales_id)->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])->sum('total_harga');

        // Jumlah Transaksi
        $jumlahTransaksi = Transaksi::where('sales_id', $request->sales_id)->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])->count();

        // Piutang
        $piutang = Transaksi::where('sales_id', $request->sales_id)
            ->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])
            ->where('tanggal_tempo', '!=', null)
            ->where('status_pembayaran', 'Belum DiBayar')
            ->sum('total_harga');

        // List Transaksi
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')
            ->where('sales_id', $request->sales_id)
            ->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])
            ->orderBy('tanggal_penjualan', 'DESC')
            ->get();

        $transaksi = $dataTransaksi ?? [];

        $waktu = tanggal_format($request->awal) . " sampai " . tanggal_format($request->akhir);

        $title = "laporan transaksi";
        return view('laporan.laporan_sales', compact('title', 'sales', 'totalPenjualan', 'jumlahTransaksi', 'piutang', 'transaksi', 'waktu'));
    }

    public function laporan_gaji(): View
    {
        $dataSales = Sales::where('status', 'pegawai')->get();

        $sales = $dataSales ?? [];

        $title = "gaji";
        return view('laporan.gaji', compact('title', 'sales'));
    }

    public function lihat_pendapatan($id)
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        $dataSales = Sales::where('id', $id)->first();

        $sales = $dataSales ?? [];

        // Total Pendapatan Sales
        $totalPenjualan = Transaksi::where('sales_id', $id)->whereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->sum('total_harga');

        // Jumlah Transaksi
        $jumlahTransaksi = Transaksi::where('sales_id', $id)->whereMonth('tanggal_penjualan', $bulan)->whereYear('tanggal_penjualan', $tahun)->count();

        // Piutang
        $piutang = Transaksi::where('sales_id', $id)
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->where('tanggal_tempo', '!=', null)
            ->where('status_pembayaran', 'Belum DiBayar')
            ->sum('total_harga');

        // List Transaksi
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')
            ->where('sales_id', $id)
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->orderBy('tanggal_penjualan', 'DESC')
            ->get();

        $transaksi = $dataTransaksi ?? [];

        $waktu = tanggal_format(date('Y-m-d', time()));

        // Rekap Gaji
        $rekapGaji = RekapGaji::where('sales_id', $id)->get();

        $title = "gaji";

        return view('laporan.gaji_sales', compact("title", 'sales', 'totalPenjualan', 'jumlahTransaksi', 'piutang', 'transaksi', 'waktu', 'rekapGaji'));
    }

    public function laporanOli(): View
    {
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
            ->where('barang.kategori_id', 1)
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan oli";
        return view('laporan.laporan_oli', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }

    public function laporanBan(): View
    {
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
            ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
            ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
            ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan ban";
        return view('laporan.laporan_ban', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }

    public function laporanSparepart(): View
    {        $transaksi = DB::table('transaksi')
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
        ->whereMonth('transaksi.tanggal_penjualan', date('m', time()))
        ->whereYear('transaksi.tanggal_penjualan', date('Y', time()))
        ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan sparepart";
        return view('laporan.laporan_sparepart', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }

    public function laporanOliTanggal(Request $request): View
    {
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
            ->where('barang.kategori_id', 1)
            ->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])
            ->orderBy('transaksi.tanggal_penjualan', 'DESC')
            ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan oli";
        return view('laporan.laporan_oli', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }

    public function laporanBanTanggal(Request $request): View
    {
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
            ->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])
            ->orderBy('transaksi.tanggal_penjualan', 'DESC')
            ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan ban";
        return view('laporan.laporan_ban', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }

    public function laporanSparepartTanggal(Request $request): View
    {
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
            ->whereBetween('tanggal_penjualan', [$request->awal, $request->akhir])
            ->orderBy('transaksi.tanggal_penjualan', 'DESC')
            ->get();

        $listTransaksi = [];
        $totalPenjualan = 0;
        $totalPendapatanBersih = 0;
        $totalPenjualanKotor = 0;
        $totalPenjualanTempo = 0;

        foreach ($transaksi as $tra) {
            $listTransaksi[] = [
                'no_invoice'    => $tra->no_invoice,
                'nama_barang'   => $tra->nama_barang,
                'sku'           => $tra->sku,
                'sales'         => $tra->nama_sales,
                'pelanggan'     => $tra->nama_pelanggan,
                'qty'           => $tra->qty,
                'harga'         => $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100)),
                'tanggal'       => $tra->tanggal_penjualan
            ];

            $totalPenjualan+= $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));

            if ($tra->status_pembayaran == "Lunas") {
                $totalPenjualanKotor += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            } else {
                $totalPenjualanTempo += $tra->total_harga - ($tra->total_harga * ($tra->diskon / 100));
            }

            if ($tra->cicilan != null) {
                $totalPenjualanKotor += $tra->cicilan;
            }

            $totalPendapatanBersih += ($tra->total_harga - ($tra->total_harga * ($tra->diskon / 100))) - ($tra->harga * $tra->qty);
        }

        $title = "laporan sparepart";
        return view('laporan.laporan_sparepart', compact("title", "listTransaksi", "totalPenjualan", "totalPendapatanBersih", "totalPenjualanKotor", "totalPenjualanTempo"));
    }
}
