<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangRusak;
use App\Models\BiayaLainnya;
use App\Models\Inbound;
use App\Models\InboundDetail;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\PembayaranCicilan;
use App\Models\Sales;
use App\Models\Sampel;
use App\Models\SampelDetail;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\TransaksiKhusus;
use App\Models\TransaksiKhususDetail;
use App\services\TrackingStokService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    protected $trackingStok;
    public function __construct(TrackingStokService $trackingStok)
    {
        $this->trackingStok = $trackingStok;
    }

    public function buat_transaksi(): View
    {
        $dataPelanggan = Pelanggan::all();
        $dataSales = Sales::all();
        $dataBarang = Barang::where('delete', null)->get();
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
                    'pelanggan_id'      => $request->post('pelanggan'),
                    'sales_id'          => $request->post('sales'),
                    'diskon'            => $request->post('diskon_penjualan'),
                    'pembayaran_id'     => $request->post('pembayaran'),
                    'no_invoice'        => 'INV-'.date('YmdHis', time()) . rand(100, 1000),
                    'harga_diskon'      => 0,
                    'biaya_lain'        => 0,
                    'total_harga'       => 0,
                    'status'            => 'penjualan',
                    'tanggal_penjualan' => $request->post('tanggal_penjualan'),
                    'tanggal_tempo'     => $request->post('tempo'),
                    'status_pembayaran' => $request->post('statusPembayaran'),
                    'jumlah_barang'     => 0,
                    'qty'               => 0
                ]);

                $jumlah_barang = 0;
                $qty_barang = 0;

                $harga = 0;
                $diskon_penjualan = $request->post('diskon_penjualan');
                $barangs = $request->post('barang');
                foreach ($barangs as $barang) {
                    $from = Inventory::where('barang_id', $barang['id'])->first();
                    if ($from->stok < $barang['qty']) {
                        abort(400,'Stok Produk '.$barang['nama'].' tidak cukup!, Stok Barang Hanya tersedia '.$from->stok);
                    }
                    $inventory = Inventory::where('barang_id', $barang['id'])->first();
                    $inventory_detail = InventoryDetail::where('inventory_id', $inventory->id)->where('qty', '!=', 0)->get();

                    $qty = $barang['qty'];
                    $loop = 0;
                    foreach ($inventory_detail as $detail) {
                        if ($qty != 0) {
                            if ($qty <= $detail->qty && $loop == 0) {
                                $total_diskon = $this->getDiskon($barang, $transaksi, $detail);
                                InventoryDetail::where('id', $detail->id)->decrement('qty', $barang['qty']);
                                $qty = 0;
                            } else {
                                if (($detail->qty - $qty) <= 0) {
                                    $total_diskon = $this->getDiskon($barang, $transaksi, $detail);
                                    InventoryDetail::where('id', $detail->id)->decrement('qty', $detail->qty);
                                    $qty = $qty - $detail->qty;
                                } else {
                                    $total_diskon = $this->getDiskon($barang, $transaksi, $detail);
                                    InventoryDetail::where('id', $detail->id)->decrement('qty', $qty);
                                    $qty = 0;
                                }
                            }
                        }
                        $loop++;
                    }

                    Inventory::where('barang_id', $barang['id'])->decrement('stok', $barang['qty']);
                    $harga += $barang['total'];

                    $jumlah_barang++;
                    $qty_barang += $barang['qty'];

                    // Tracking Stok
                    $to = Inventory::where('barang_id', $barang['id'])->first();
                    $this->trackingStok->trackingStokTransaksi($inventory->id, $transaksi->id, null, $barang['qty'], $from->stok, $to->stok, 'decrement', 'Penjualan Barang');
                }

                $totalDiskon = $harga * ($diskon_penjualan / 100);
                $totalHarga = $harga - $totalDiskon;
                Transaksi::where('id', $transaksi->id)->update([
                    'harga_diskon'  => $totalDiskon,
                    'total_harga'   => $totalHarga,
                    'jumlah_barang' => $jumlah_barang,
                    'qty'           => $qty_barang
                ]);

            DB::commit();

                return response([
                    'status'    => true,
                    'message'   => 'Buat Penjualan berhasil'
                ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Penjualan, ' . $err->getMessage());
            return response([
                'status'    => false,
                'message'   => 'Buat Penjualan gagal, ' . $err->getMessage()
            ]);
        }
    }

    /**
     * @param mixed $barang
     * @param $transaksi
     * @param mixed $detail
     * @return float|int|mixed
     */
    private function getDiskon(mixed $barang, $transaksi, mixed $detail): mixed
    {
        $total_diskon = ($barang['harga'] * $barang['qty']) - $barang['total'];
        TransaksiDetail::create([
            'transaksi_id'          => $transaksi->id,
            'barang_id'             => $barang['id'],
            'inventory_detail_id'   => $detail->id,
            'harga'                 => $barang['harga'],
            'diskon_barang'         => $barang['diskon'],
            'qty'                   => $barang['qty'],
            'total_diskon'          => $total_diskon,
            'total_harga'           => $barang['total']
        ]);
        return $total_diskon;
    }

    public function daftar_transaksi(): View
    {
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->orderBy('tanggal_penjualan', 'DESC')->get();

        $transaksi = $dataTransaksi ?? [];

        $title = "daftar transaksi";
        return view('outbound.daftar', compact('title', 'transaksi'));
    }

    public function detail_transaksi($id): View
    {
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->where('id', $id)->first();
        $dataTransaksiDetail = TransaksiDetail::with('barang')->where('transaksi_id', $dataTransaksi->id)->get();

        $transaksi = $dataTransaksi ?? [];
        $transaksiDetail = $dataTransaksiDetail ?? [];

        $title = "daftar transaksi";
        return view('outbound.detail', compact('title', 'transaksi', 'transaksiDetail'));
    }

    public function cetak_nota_transaksi($id)
    {
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->where('id', $id)->first();
        $dataTransaksiDetail = TransaksiDetail::with('barang')->where('transaksi_id', $dataTransaksi->id)->get();

        $transaksi = $dataTransaksi ?? [];
        $transaksiDetail = $dataTransaksiDetail ?? [];

        $customPaper = [0, 0, 684, 792];
        $pdf = Pdf::loadView('pdf.invoice', ['transaksi' => $transaksi, 'barang' => $transaksiDetail]);
        $pdf->setPaper($customPaper, 'landscape');
        return $pdf->stream('invoice.pdf');
    }

    public function buat_sampel_sales(): View
    {
        $dataSales = Sales::all();
        $dataBarang = Barang::where('delete', null)->get();

        $sales = $dataSales ?? [];
        $barang  = $dataBarang ?? [];

        $title = "buat sampel";
        return view('outbound.buat_sampel', compact('title', 'sales', 'barang'));
    }

    public function buat_sampel_sales_post(Request $request)
    {
        try {
            DB::beginTransaction();
                $sampel = Sampel::create([
                    'sales_id'          => $request->post('sales'),
                    'no_sampel'         => 'SPL-'.date('Ymd', time()) . rand(100, 1000),
                    'jumlah_barang'     => 0,
                    'qty'               => 0,
                    'status'            => 'sampel',
                    'total_harga'       => 0,
                    'tanggal_sampel'    => $request->post('tanggal_pembuatan')
                ]);

                $jumlah_barang = 0;
                $jumlah_qty = 0;
                $total_harga = 0;
                $dataBarang = $request->post('barang');
                foreach ($dataBarang as $barang) {
                    $from = Inventory::where('barang_id', $barang['id'])->first();
                    if ($from->stok < $barang['qty']) {
                        abort(400,'Stok Produk '.$barang['nama'].' tidak cukup!, Stok Barang Hanya tersedia '.$from->stok);
                    }
                    $inventory = Inventory::where('barang_id', $barang['id'])->first();
                    $inventory_detail = InventoryDetail::where('inventory_id', $inventory->id)->where('qty', '!=', 0)->get();

                    $total_harga += $barang['total'];
                    $jumlah_qty += $barang['qty'];
                    $jumlah_barang++;

                    $qty = $barang['qty'];
                    $loop = 0;
                    foreach ($inventory_detail as $detail) {
                        if ($qty != 0) {
                            if ($qty <= $detail->qty && $loop == 0) {
                                InventoryDetail::where('id', $detail->id)->decrement('qty', $barang['qty']);
                                SampelDetail::create([
                                    'sampel_id'             => $sampel->id,
                                    'barang_id'             => $barang['id'],
                                    'inventory_detail_id'   => $detail->id,
                                    'qty'                   => $barang['qty'],
                                    'harga'                 => $barang['harga'],
                                    'total_harga'           => $barang['total']
                                ]);
                                $qty = 0;
                            } else {
                                if (($detail->qty - $qty) <= 0) {
                                    InventoryDetail::where('id', $detail->id)->decrement('qty', $detail->qty);
                                    SampelDetail::create([
                                        'sampel_id'             => $sampel->id,
                                        'barang_id'             => $barang['id'],
                                        'inventory_detail_id'   => $detail->id,
                                        'qty'                   => $barang['qty'],
                                        'harga'                 => $barang['harga'],
                                        'total_harga'           => $barang['total']
                                    ]);
                                    $qty = $qty - $detail->qty;
                                } else {
                                    InventoryDetail::where('id', $detail->id)->decrement('qty', $qty);
                                    SampelDetail::create([
                                        'sampel_id'             => $sampel->id,
                                        'barang_id'             => $barang['id'],
                                        'inventory_detail_id'   => $detail->id,
                                        'qty'                   => $barang['qty'],
                                        'harga'                 => $barang['harga'],
                                        'total_harga'           => $barang['total']
                                    ]);
                                    $qty = 0;
                                }
                            }

                            $loop++;
                        }
                    }
                    Inventory::where('barang_id', $barang['id'])->decrement('stok', $barang['qty']);

                    // Tracking Stok
                    $to = Inventory::where('barang_id', $barang['id'])->first();
                    $this->trackingStok->trackingStokSampel($inventory->id, $sampel->id, null, $barang['qty'], $from->stok, $to->stok, 'decrement', 'Sampel Barang');
                }

                Sampel::where('id', $sampel->id)->update([
                    'jumlah_barang'     => $jumlah_barang,
                    'qty'               => $jumlah_qty,
                    'total_harga'       => $total_harga,
                ]);

            DB::commit();
            return response([
                'status'     => true,
                'message'    => "Buat sample berhasil"
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Buat Sampel, ' . $err->getMessage());
            return response([
               'status'     => false,
               'message'    => "Buat sample error, " . $err->getMessage()
            ]);
        }
    }

    public function list_sampel(): View
    {
        $dataSampel = Sampel::with('sales')->get();

        $sampel = $dataSampel ?? [];

        $title = "list sampel";
        return view('outbound.list_sampel', compact('title', 'sampel'));
    }

    public function detail_sampel($id): View
    {
        $dataSampel = Sampel::with('sales')->where('id', $id)->first();
        $dataSampelDetail = SampelDetail::with('barang')->where('sampel_id', $id)->get();

        $sampel = $dataSampel ?? [];
        $sampelDetail = $dataSampelDetail ?? [];

        $title = "list sampel";
        return view('outbound.detail_sampel', compact('title', 'sampel', 'sampelDetail'));
    }

    public function cetak_nota_sampel($id)
    {
        $sampel = Sampel::with('sales')->where('id', $id)->first();
        $sampelDetail = SampelDetail::with('barang')->where('sampel_id', $id)->get();

        $pdf = Pdf::loadView('pdf.sampel', ['sampel' => $sampel, 'sampelDetail' => $sampelDetail]);
        return $pdf->stream('nota-sampel.pdf');
    }

    public function return_sampel(): View
    {
        $dataSampel = Sampel::with('sales')->get();

        $sampel = $dataSampel ?? [];

        $title = "return sampel";
        return view('outbound.return_sampel', compact('title', 'sampel'));
    }

    public function proses_return_sampel($id)
    {
        $dataSampel = Sampel::with('sales')->where('id', $id)->first();
        $dataSampelDetail = SampelDetail::with('barang')->where('sampel_id', $id)->get();

        $sampel = $dataSampel ?? [];
        $sampelDetail = $dataSampelDetail ?? [];

        $title = "return sampel";
        return view('outbound.proses_sampel_return', compact('title', 'sampel', 'sampelDetail'));
    }

    public function proses_return_sampel_post(Request $request)
    {
        try {
            DB::beginTransaction();
                $sampelDetailId = $request->post('sampel_detail_id');
                $status = $request->post('status');

                for ($a = 0; $a < count($sampelDetailId); $a++) {
                    $sampleDetail = SampelDetail::where('id', $sampelDetailId[$a])->first();
                    $checkBarangRusak = BarangRusak::where('barang_id', $sampleDetail->barang_id)->count();

                    if ($status[$a] == 2) {
                        if ($checkBarangRusak == 0) {
                            $inboundDetail = InboundDetail::where('barang_id', $sampleDetail->barang_id)->first();
                            $inbound = Inbound::where('id', $inboundDetail->id)->first();
                            BarangRusak::create([
                                'barang_id'     => $sampleDetail->barang_id,
                                'supplier_id'   => $inbound->supplier_id,
                                'stok'          => $sampleDetail->qty
                            ]);
                        } else {
                            BarangRusak::where('barang_id', $sampleDetail->barang_id)->increment('stok', $sampleDetail->qty);
                        }
                        SampelDetail::where('id', $sampleDetail->id)->update([
                            'status'    => 2
                        ]);
                    } elseif ($status[$a] == 3) {
                        $from = Inventory::where('barang_id', $sampleDetail->barang_id)->first();
                        Inventory::where('barang_id', $sampleDetail->barang_id)->increment('stok', $sampleDetail->qty);
                        InventoryDetail::where('id', $sampleDetail->inventory_detail_id)->increment('qty', $sampleDetail->qty);
                        SampelDetail::where('id', $sampleDetail->id)->update([
                            'status'    => 3
                        ]);
                        // Tracking Stok
                        $to = Inventory::where('barang_id', $sampleDetail->barang_id)->first();
                        $this->trackingStok->trackingStokSampel($from->id, $request->post('sampel_id'), null, $sampleDetail->qty, $from->stok, $to->stok, 'increment', 'Sampel Barang');
                    }
                }
            DB::commit();

            Session::flash('success', 'Proses Return Sampel Berhasil');
            return back();
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Return Sampel, ' . $err->getMessage());
            Session::flash('error', 'Proses Return Sampel Gagal');
            return back();
        }
    }

    public function return_transaksi()
    {
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->get();

        $transaksi = $dataTransaksi ?? [];

        $title = "return transaksi";
        return view('outbound.return_transaksi', compact('title', 'transaksi'));
    }

    public function proses_return_transaksi($id)
    {
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->where('id', $id)->first();
        $dataTransaksiDetail = TransaksiDetail::with('barang')->where('transaksi_id', $dataTransaksi->id)->get();

        $transaksi = $dataTransaksi ?? [];
        $transaksiDetail = $dataTransaksiDetail ?? [];

        $title = "return transaksi";
        return view('outbound.proses_return_transaksi', compact('title', 'transaksi', 'transaksiDetail'));
    }

    public function proses_return_transaksi_post(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
                $transaksiDetailId = $request->post('transaksiDetailId');
                $status = $request->post('status');
                $jumlah = $request->post('jumlah');

                for ($a = 0; $a < count($transaksiDetailId); $a++) {
                    if ($jumlah[$a] != 0 && $status != 1) {
                        if ($status[$a] == 2) {
                            // Barang Rusak
                            $transaksiDetail = TransaksiDetail::where('id', $transaksiDetailId[$a])->first();
                            $hargaSatuan = $transaksiDetail->total_harga / $transaksiDetail->qty;
                            $harga = $hargaSatuan * $jumlah[$a];
                            Transaksi::where('id', $transaksiDetail->transaksi_id)->decrement('total_harga', $harga);
                            TransaksiDetail::where('id', $transaksiDetail->id)->decrement('total_harga', $harga);
                            TransaksiDetail::where('id', $transaksiDetail->id)->update([
                                'status'    =>  2
                            ]);

                            Transaksi::where('id', $transaksiDetail->transaksi_id)->update([
                                'status'    => 'return'
                            ]);

                            $checkBarangRusak = BarangRusak::where('barang_id', $transaksiDetail->barang_id)->count();

                            if ($checkBarangRusak == 0) {
                                $inboundDetail = InboundDetail::where('barang_id', $transaksiDetail->barang_id)->first();
                                $inbound = Inbound::where('id', $inboundDetail->id)->first();
                                BarangRusak::create([
                                    'barang_id'     => $transaksiDetail->barang_id,
                                    'supplier_id'   => $inbound->supplier_id,
                                    'stok'          => $jumlah[$a]
                                ]);
                            } else {
                                BarangRusak::where('barang_id', $transaksiDetail->barang_id)->increment('stok', $jumlah[$a]);
                            }
                        } elseif ($status[$a] == 3) {
                            // Barang Kembali
                            $transaksiDetail = TransaksiDetail::where('id', $transaksiDetailId[$a])->first();
                            $from = Inventory::where('barang_id', $transaksiDetail->barang_id)->first();
                            $hargaSatuan = $transaksiDetail->total_harga / $transaksiDetail->qty;
                            $harga = $hargaSatuan * $jumlah[$a];
                            Transaksi::where('id', $transaksiDetail->transaksi_id)->decrement('total_harga', $harga);
                            TransaksiDetail::where('id', $transaksiDetail->id)->decrement('total_harga', $harga);
                            TransaksiDetail::where('id', $transaksiDetail->id)->update([
                                'status'    =>  3
                            ]);

                            Transaksi::where('id', $transaksiDetail->transaksi_id)->update([
                                'status'    => 'return'
                            ]);

                            Inventory::where('barang_id', $transaksiDetail->barang_id)->increment('stok', $jumlah[$a]);
                            InventoryDetail::where('id', $transaksiDetail->inventory_detail_id)->increment('qty', $jumlah[$a]);

                            // Tracking Stok
                            $to = Inventory::where('barang_id', $transaksiDetail->barang_id)->first();
                            $inventory = Inventory::where('barang_id', $transaksiDetail->barang_id)->first();
                            $this->trackingStok->trackingStokTransaksi($inventory->id, $transaksiDetail->transaksi_id, null, $transaksiDetail->barang_id, $from->stok, $to->stok, 'increment', 'Return Penjualan');
                        }
                    }
                }
            DB::commit();
            Session::flash('success', 'Return Transaksi Berhasil');
            return back();
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Return Transaksi, ' . $err->getMessage());
            Session::flash('error', 'Return Transaksi Gagal');
            return back();
        }
    }

    public function pengambilan_barang()
    {
        $dataSales = Sales::all();
        $dataBarang = Barang::where('delete', null)->get();

        $sales = $dataSales ?? [];
        $barang  = $dataBarang ?? [];

        $title = "ambil barang";
        return view('outbound.ambil_barang', compact('title', 'sales', 'barang'));
    }

    public function pengambilan_barang_post(Request $request)
    {
        try {
            DB::beginTransaction();
                $transaksiKhusus = TransaksiKhusus::create([
                    'sales_id'              => $request->post('sales'),
                    'no_transaksi_khusus'   => 'TKHS-' . date('YmdHis', time()),
                    'jumlah_barang'         => count($request->post('barang')),
                    'qty'                   => 0,
                    'tanggal_pengambilan'   => $request->post('tanggal_pengambilan')
                ]);

                $qty = 0;
                $barang = $request->post('barang');

                foreach ($barang as $b) {
                    TransaksiKhususDetail::create([
                        'transaksi_khusus_id'   => $transaksiKhusus->id,
                        'barang_id'             => $b['id'],
                        'qty'                   => $b['qty']
                    ]);
                    $qty += $b['qty'];
                }

                TransaksiKhusus::where('id', $transaksiKhusus->id)->update([
                    'qty'   => $qty,
                ]);
            DB::commit();
            Session::flash('success', 'Pengambilan Barang Berhasil');
            return response([
                'status'    => true,
                'message'   => 'Pengambilan Barang Berhasil'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Pengambilan Barang Error, ' . $err->getMessage());
            Session::flash('error', 'Pengambilan Barang Gagal');
            return response([
                'status'    => false,
                'message'   => 'Pengambilan Barang Gagal'
            ]);
        }
    }

    public function sisa_barang()
    {
        $transaksiKhusus = TransaksiKhusus::with('sales')->get();

        $title = "sisa barang";
        return view('outbound.sisa_barang', compact('title', 'transaksiKhusus'));
    }

    public function proses_pengembalian_barang($id)
    {
        $transaksiKhusus = TransaksiKhusus::with('sales')->where('id', $id)->first();
        $transaksiKhususDetail = TransaksiKhususDetail::with('barang')->where('transaksi_khusus_id', $transaksiKhusus->id)->get();

        $title = "sisa barang";
        return view('outbound.proses_pengembalian', compact('title', 'transaksiKhusus', 'transaksiKhususDetail'));
    }

    public function proses_pengembalian_barang_post (Request $request)
    {
        $id = $request->post('id');
        $qty = $request->post('qty');

        for ($a = 0; $a < count($id); $a++) {
            TransaksiKhususDetail::where('id', $id[$a])->update([
                'qty_kembali'   => $qty[$a]
            ]);
        }

        Session::flash('success', 'Proses Pengembalian Barang Berhasil');
        return back();
    }

    public function proses_pembayaran(Request $request)
    {
        Transaksi::where('id', $request->post('id'))->update([
            'status_pembayaran'     => 'Lunas'
        ]);

        return response([
            'status'    => true
        ]);
    }

    public function transaksi_khusus_alif()
    {
        $dataPelanggan = Pelanggan::all();
        $dataSales = Sales::all();
        $dataBarang = Barang::where('delete', null)->get();
        $dataPembayaran = Pembayaran::all();

        $pelanggan = $dataPelanggan ?? [];
        $sales = $dataSales ?? [];
        $barang  = $dataBarang ?? [];
        $pembayaran = $dataPembayaran ?? [];

        $title = "buat transaksi alif";
        return view('outbound.buat_transaksi_alif', compact('title', 'pelanggan', 'sales', 'barang', 'pembayaran'));
    }

    public function biayaLainnya(): View
    {
        $sales = Sales::all();
        $biayaLainnya = BiayaLainnya::with('sales')->get();

        $title = "biaya lainnya";
        return view("lain.biaya_lainnya", compact("title", "biayaLainnya", "sales"));
    }

    public function tambahBiayaLainnya(Request $request)
    {
        BiayaLainnya::create([
            'sales_id'      => $request->post('sales'),
            'tanggal'       => $request->post('tanggal'),
            'nominal'       => $request->post('nominal'),
            'keterangan'    => $request->post('keterangan')
        ]);

        Session::flash('success', 'Tambah Biaya Lainnya Berhasil');
        return back();
    }

    public function bayarCicilan(Request $request)
    {
        try {
            DB::beginTransaction();
            PembayaranCicilan::create([
                'transaksi_id'   => $request->post('transaksi_id'),
                'jumlah'         => $request->post('jumlah'),
                'tanggal'        => $request->post('tanggal'),
            ]);

            $dataTransaksi = Transaksi::where('id', $request->post('transaksi_id'))->first();
            if ($dataTransaksi->cicilan != null) {
                Transaksi::where('id', $request->post('transaksi_id'))->increment('cicilan', (int)$request->post('jumlah'));
            } else {
                Transaksi::where('id', $request->post('transaksi_id'))->update([
                    'cicilan'     => $request->post('jumlah')
                ]);
            }

            $transaksi = Transaksi::where('id', $request->post('transaksi_id'))->first();
            if ($transaksi->total_harga == $transaksi->cicilan) {
                Transaksi::where('id', $request->post('transaksi_id'))->update([
                    'status_pembayaran'     => 'Lunas'
                ]);
            }

            if ($transaksi->total_harga < $transaksi->cicilan) {
                abort(400, 'Nominal melebihi total transaksi');
            }

            DB::commit();

            Session::flash('success', 'Pembayaran Cicilan Berhasil di buat');
            return back();
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Pembayaran Cicilan Gagal di buat '. $err->getMessage());
            return back();
        }
    }
}
