<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Transaksi;
use Carbon\Carbon;
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
                $mulai = $tahun.'-'.Carbon::now()->subMonth()->month.'-20';
                $selesai = $tahun.'-'.$bulan.'-20';

                Log::channel('gaji')->info('mulai = '. $mulai);
                Log::channel('gaji')->info('selesai = '. $selesai);

                $pendapatanKotor = Transaksi::WhereMonth('tanggal_penjualan', $bulan)
                    ->whereBetween('tanggal_penjualan', [$mulai, $selesai])
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
                    ->whereBetween('tanggal_penjualan', [$mulai, $selesai])
                    ->where('transaksi.sales_id', $sales_id)
                    ->get();

                $dataPendapatanBersih = 0;
                foreach ($dataTransaksi as $detail) {
                    $dataPendapatanBersih += $detail->harga * $detail->qty;
                }

                $pendapatanBersih = $pendapatanKotor - $dataPendapatanBersih;

                Log::channel('gaji')->info($pendapatanKotor);
                Log::channel('gaji')->info($dataPendapatanBersih);
                Log::channel('gaji')->info('pendapatan bersih alip = ' . $pendapatanBersih);
                break;
            case 3:
        }
    }
}
