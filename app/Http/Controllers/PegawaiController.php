<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Pegawai;
use App\Models\RekapGaji;
use App\Models\Sales;
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
        $bulan = date('m', time());
        $tahun = date('Y', time());

        switch ($sales_id) {
            case 2 :
                // Hitung Gaji ALIP
                $mulai = $tahun.'-'.Carbon::now()->subMonth()->month.'-20';
                $selesai = $tahun.'-'.$bulan.'-20';

                $pendapatanKotor = Transaksi::whereBetween('tanggal_penjualan', [$mulai, $selesai])
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
                break;
            case 3:
                if (date('m', time()) == 01 || date('m', time()) == '01') {
                    $tahun = Carbon::now()->subYear()->year;
                }

                // Hitung Gaji Oli HiPower
                $transaksiHiPower = DB::table('transaksi')
                                ->select([
                                    'transaksi.diskon',
                                    'transaksi.sales_id',
                                    'transaksi_detail.total_harga',
                                    'transaksi_detail.barang_id',
                                ])
                                ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                                ->where('transaksi.sales_id', 3)
                                ->where('transaksi.status_pembayaran', 'lunas')
                                ->WhereMonth('tanggal_penjualan', $bulan)
                                ->whereYear('tanggal_penjualan', $tahun)
                                ->where('transaksi_detail.barang_id', 30)
                                ->orWhere('transaksi_detail.barang_id', 29)
                                ->orWhere('transaksi_detail.barang_id', 28)
                                ->orWhere('transaksi_detail.barang_id', 31)
                                ->get();

                $totalHiPower = 0;
                foreach ($transaksiHiPower as $h) {
                    if ($h->sales_id == $sales_id) {
                        $diskon = $h->diskon / 100;
                        $harga = $h->total_harga - ($h->total_harga * $diskon);
                        $totalHiPower += $harga;
                    }
                }

                // Hitung Transaksi Sparepart
                $transaksiSparepart = DB::table('transaksi')
                    ->select([
                        'barang.kategori_id',
                        'transaksi.diskon',
                        'transaksi.sales_id',
                        'transaksi_detail.total_harga',
                        'transaksi_detail.barang_id',
                    ])
                    ->leftJoin('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
                    ->leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
                    ->where('transaksi.sales_id', 3)
                    ->where('transaksi.status_pembayaran', 'lunas')
                    ->where('barang.kategori_id', 3)
                    ->WhereMonth('tanggal_penjualan', $bulan)
                    ->whereYear('tanggal_penjualan', $tahun)
                    ->get();

                $totalSparepart = 0;
                foreach ($transaksiSparepart as $h) {
                    if ($h->sales_id == $sales_id) {
                        $diskon = $h->diskon / 100;
                        $harga = $h->total_harga - ($h->total_harga * $diskon);
                        $totalSparepart += $harga;
                    }
                }

                // Hitung Bonus Penjualan
                $bonusOli = $totalHiPower * 0.02;
                $bonusSparepart = $totalSparepart * 0.01;

                // Absensi Sales
                $dataAbsenMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataAbsenTidakMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'tidak masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataSales = Sales::where('id', $sales_id)->first();

                $potonganTidakMasuk = $dataAbsenTidakMasuk * 70000;

                $uangMakan = ($dataAbsenMasuk * $dataSales->uang_makan) - ($dataAbsenTidakMasuk * $dataSales->uang_makan);
                $uangBensin = ($dataAbsenMasuk * $dataSales->uang_bensin) - ($dataAbsenTidakMasuk * $dataSales->uang_bensin);

                $gajiBersih = $dataSales->gaji_pokok + $uangBensin + $uangBensin + $dataSales->sewa_kendaraan + $bonusOli + $bonusSparepart - $potonganTidakMasuk;

                // Insert Rekap Gaji
                RekapGaji::create([
                    'sales_id'          => $sales_id,
                    'gaji_pokok'        => $dataSales->gaji_pokok,
                    'uang_makan'        => $uangMakan,
                    'uang_bensin'       => $uangBensin,
                    'sewa_kendaraan'    => $dataSales->sewa_kendaraan,
                    'operasional'       => '-',
                    'kas_bon'           => '-',
                    'potongan'          => $potonganTidakMasuk,
                    'total_penjualan'   => $totalHiPower + $totalSparepart,
                    'bonus_penjualan'   => $bonusOli + $bonusSparepart,
                    'gaji_bersih'       => $gajiBersih,
                    'keterangan'        => 'Gaji Bulan '. date('M', time()).', total masuk dalam 1 bulan = '.$dataAbsenMasuk.', tidak masuk = '.$dataAbsenTidakMasuk,
                    'tanggal'           => date('Y-m-d H:i:s', time())
                ]);
                break;
            case 16:
                // Gaji Wawan
                if (date('m', time()) == 01 || date('m', time()) == '01') {
                    $tahunMulai = Carbon::now()->subYear()->year;
                } else {
                    $tahunMulai = date('Y', time());
                }

                $dataAbsenMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'masuk')
                    ->whereBetween('tanggal_absen', [$tahunMulai.'-'.Carbon::now()->subMonth()->month.'-20', $tahun.'-'.$bulan.'-19'])
                    ->count();

                $dataAbsenTidakMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'tidak masuk')
                    ->whereBetween('tanggal_absen', [$tahunMulai.'-'.Carbon::now()->subMonth()->month.'-20', $tahun.'-'.$bulan.'-19'])
                    ->count();

                $dataSales = Sales::where('id', $sales_id)->first();

                $potonganTidakMasuk = $dataAbsenTidakMasuk * 70000;

                $gajiBersih = $dataSales->gaji_pokok - $potonganTidakMasuk;

                // Insert Rekap Gaji
                RekapGaji::create([
                    'sales_id'          => $sales_id,
                    'gaji_pokok'        => $dataSales->gaji_pokok,
                    'uang_makan'        => 0,
                    'uang_bensin'       => 0,
                    'sewa_kendaraan'    => 0,
                    'operasional'       => 0,
                    'kas_bon'           => 0,
                    'potongan'          => $potonganTidakMasuk,
                    'total_penjualan'   => 0,
                    'bonus_penjualan'   => 0,
                    'gaji_bersih'       => $gajiBersih,
                    'keterangan'        => 'Gaji Bulan '. date('M', time()).', total masuk dalam 1 bulan = '.$dataAbsenMasuk.', tidak masuk = '.$dataAbsenTidakMasuk,
                    'tanggal'           => date('Y-m-d H:i:s', time())
                ]);
                break;
            case 17:
                // Gaji Yoga
                if (date('m', time()) == 01 || date('m', time()) == '01') {
                    $tahun = Carbon::now()->subYear()->year;
                }

                $dataAbsenMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataAbsenTidakMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'tidak masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataSales = Sales::where('id', $sales_id)->first();

                $potonganTidakMasuk = $dataAbsenTidakMasuk * 70000;

                $gajiBersih = $dataSales->gaji_pokok - $potonganTidakMasuk;

                // Insert Rekap Gaji
                RekapGaji::create([
                    'sales_id'          => $sales_id,
                    'gaji_pokok'        => $dataSales->gaji_pokok,
                    'uang_makan'        => 0,
                    'uang_bensin'       => 0,
                    'sewa_kendaraan'    => 0,
                    'operasional'       => 0,
                    'kas_bon'           => 0,
                    'potongan'          => $potonganTidakMasuk,
                    'total_penjualan'   => 0,
                    'bonus_penjualan'   => 0,
                    'gaji_bersih'       => $gajiBersih,
                    'keterangan'        => 'Gaji Bulan '. date('M', time()).', total masuk dalam 1 bulan = '.$dataAbsenMasuk.', tidak masuk = '.$dataAbsenTidakMasuk,
                    'tanggal'           => date('Y-m-d H:i:s', time())
                ]);
                break;
            case 18:
                // Gaji Rafika
                if (date('m', time()) == 01 || date('m', time()) == '01') {
                    $tahun = Carbon::now()->subYear()->year;
                }

                $dataAbsenMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataAbsenTidakMasuk = Absen::where('pegawai_id', $sales_id)
                    ->where('absen', 'tidak masuk')
                    ->WhereMonth('tanggal_absen', $bulan)
                    ->whereYear('tanggal_absen', $tahun)
                    ->count();

                $dataSales = Sales::where('id', $sales_id)->first();

                $gajiBersih = $dataSales->gaji_pokok;

                // Insert Rekap Gaji
                RekapGaji::create([
                    'sales_id'          => $sales_id,
                    'gaji_pokok'        => $dataSales->gaji_pokok,
                    'uang_makan'        => 0,
                    'uang_bensin'       => 0,
                    'sewa_kendaraan'    => 0,
                    'operasional'       => 0,
                    'kas_bon'           => 0,
                    'potongan'          => 0,
                    'total_penjualan'   => 0,
                    'bonus_penjualan'   => 0,
                    'gaji_bersih'       => $gajiBersih,
                    'keterangan'        => 'Gaji Bulan '. date('M', time()).', total masuk dalam 1 bulan = '.$dataAbsenMasuk.', tidak masuk = '.$dataAbsenTidakMasuk,
                    'tanggal'           => date('Y-m-d H:i:s', time())
                ]);
                break;
        }
    }
}
