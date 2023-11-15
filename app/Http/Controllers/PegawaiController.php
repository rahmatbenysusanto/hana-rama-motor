<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    public function tambah_pegawai(Request $request): \Illuminate\Http\RedirectResponse
    {
        Pegawai::create([
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp')
        ]);

        Session::flash('success', 'Tambah Pegawai Berhasil');
        return back();
    }

    public function hitungGajiPegawai($sales_id)
    {
        $bulan = date('d', time());
        $tahun = date('Y', time());

        switch ($sales_id) {
            case 2 :
                // Hitung Gaji ALIP
                $pendapatanKotor = Transaksi::WhereMonth('tanggal_penjualan', $bulan)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->where('status_pembayaran', 'Lunas')
                    ->where('sales_id', $sales_id)
                    ->sum('total_harga');

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
                    ->where('sales_id', $sales_id)
                    ->get();

                $dataPendapatanBersih = 0;
                foreach ($dataTransaksi as $detail) {
                    $dataPendapatanBersih += $detail->harga * $detail->qty;
                }

                $pendapatanBersih = $pendapatanKotor - $dataPendapatanBersih;

                Log::channel('gaji')->info('pendapatan bersih alip = ' . $pendapatanBersih);
                break;
            case 3:
        }
    }
}
