<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Sales;
use App\Models\Sampel;
use App\Models\SampelDetail;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function buat_transaksi(): View
    {
        $dataPelanggan = Pelanggan::all();
        $dataSales = Sales::all();
        $dataBarang = Barang::all();
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
                    'jumlah_barang'     => 0,
                    'qty'               => 0
                ]);

                $jumlah_barang = 0;
                $qty_barang = 0;

                $harga = 0;
                $diskon_penjualan = $request->post('diskon_penjualan');
                $barangs = $request->post('barang');
                foreach ($barangs as $barang) {
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
                    $qty_barang = $barang['qty'];
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
                'message'   => 'Buat Penjualan gagal'
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
        $dataTransaksi = Transaksi::with('sales', 'pelanggan', 'pembayaran')->get();

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
        $customPaper = [0, 0, 684, 792];
        $pdf = Pdf::loadView('pdf.invoice', []);
        $pdf->setPaper($customPaper, 'landscape');
        return $pdf->stream('invoice.pdf');
    }

    public function buat_sampel_sales(): View
    {
        $dataSales = Sales::all();
        $dataBarang = Barang::all();

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
               'message'    => "Buat sample error"
            ]);
        }
    }
}
