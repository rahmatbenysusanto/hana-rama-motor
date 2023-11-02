<?php

namespace App\Http\Controllers;

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

        $title = "laporan transaksi";
        return view('laporan.laporan_sales', compact('title', 'sales', 'totalPenjualan', 'jumlahTransaksi', 'piutang', 'transaksi'));
    }
}
