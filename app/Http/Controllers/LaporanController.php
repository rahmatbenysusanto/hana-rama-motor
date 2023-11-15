<?php

namespace App\Http\Controllers;

use App\Models\RekapGaji;
use App\Models\Sales;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function laporan_transaksi():View
    {
        $dataSales = Sales::where('id', '!=', 1)->get();

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

        $waktu = tanggal_format(date('Y-m-d', time()));

        $title = "laporan transaksi";
        return view('laporan.laporan_sales', compact('title', 'sales', 'totalPenjualan', 'jumlahTransaksi', 'piutang', 'transaksi', 'waktu'));
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
        $dataSales = Sales::whereNotIn('id', [1])->get();

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
}
