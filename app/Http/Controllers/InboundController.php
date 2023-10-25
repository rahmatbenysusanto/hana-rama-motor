<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangRusak;
use App\Models\Inbound;
use App\Models\InboundDetail;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class InboundController extends Controller
{
    public function tambah_barang_baru(): View
    {
        $kategori = Kategori::all();

        $title = "tambah barang baru";
        return view('inbound.buat_barang', compact('title', 'kategori'));
    }

    public function tambah_barang_baru_post(Request $request)
    {
        $validated = $request->validate([
            'sku'           => 'required',
            'nama_barang'   => 'required',
            'kategori'      => 'required',
            'harga_sales'   => 'required',
            'harga_umum'    => 'required',
        ]);

        // Cek apakah barang sudah ada dimaster barang
        $check1 = Barang::where('sku', $request->post('sku'))->count();

        if ($check1 == 0) {
            $check2 = Barang::where('nama_barang', $request->post('nama_barang'))->count();
            if ($check2 == 0) {
                $barang = Barang::create([
                    'sku'           => $request->post('sku'),
                    'nama_barang'   => $request->post('nama_barang'),
                    'kategori_id'   => $request->post('kategori'),
                    'harga_umum'    => $request->post('harga_umum'),
                    'harga_sales'   => $request->post('harga_sales'),
                ]);

                Inventory::create([
                   "barang_id"  => $barang->id,
                   "stok"       => 0
                ]);

                Session::flash('success', 'Tambah Barang Berhasil');
            } else {
                Session::flash('error', 'Tambah Barang Gagal!, Barang sudah ada di master barang');
            }
        } else {
            Session::flash('error', 'Tambah Barang Gagal!, Barang sudah ada di master barang');
        }

        return back();
    }

    public function tambah_pembelian_barang(): View
    {
        $barang = Barang::with('kategori')->get();
        $supplier = Supplier::all();

        $title = "tambah stok barang";
        return view('inbound.tambah_stok', compact('title', 'barang', 'supplier'));
    }

    public function tambah_pembelian_barang_post(Request $request)
    {
        try {
            DB::beginTransaction();
                $barang = $request->post('barang');
                $inbound = Inbound::create([
                    'supplier_id'       => $request->post('supplier'),
                    'po_number'         => 'PO' . date('Ymd', time()) . rand(100, 1000),
                    'no_invoice'        => $request->post('invoice'),
                    'jumlah_barang'     => 0,
                    'qty_barang'        => 0,
                    'tanggal_datang'    => $request->post('tanggal_datang'),
                    'diskon_pembelian'  => $request->post('diskon_pembelian'),
                    'ppn'               => $request->post('ppn'),
                    'total_harga'       => 0,
                    'type'              => 'pembelian'
                ]);

                $totalHarga = 0;
                $totalQty = 0;
                $qtyBarang = 0;

                $ppn = $request->post('ppn');
                $diskon_pembalian = $request->post('diskon_pembelian');
                foreach ($barang as $b) {
                    $harga = $b['total'];

                    if ($diskon_pembalian != 0) {
                        $diskon = $harga * ($diskon_pembalian / 100);
                        $harga = $harga - $diskon;
                    }

                    if ($ppn != 0) {
                        $diskon = $harga * ($ppn / 100);
                        $harga = $harga + $diskon;
                    }

                    $totalHarga += $harga;

                    $totalQty += $b['qty'];
                    $qtyBarang++;
                    InboundDetail::create([
                        'inbound_id'    => $inbound->id,
                        'barang_id'     => $b['id'],
                        'qty'           => $b['qty'],
                        'harga'         => $b['harga'],
                        'diskon'        => $b['diskon'],
                        'total_harga'   => $harga
                    ]);

                    // Tambah Stok Inventory
                    Inventory::where('barang_id', $b['id'])->increment('stok', $b['qty']);

                    // Inventory Detail
                    $inventory = Inventory::where('barang_id', $b['id'])->first();
                    $inventoryDetail = InventoryDetail::where('inventory_id', $inventory->id)
                        ->where('harga', ($harga / $b['qty']))
                        ->first();
                    if ($inventoryDetail != null) {
                        InventoryDetail::where('id', $inventoryDetail->id)->increment('qty', $b['qty']);
                    } else {
                        InventoryDetail::create([
                            'inventory_id'  => $inventory->id,
                            'harga'         => ($harga / $b['qty']),
                            'qty'           => $b['qty']
                        ]);
                    }
                }

                Inbound::where('id', $inbound->id)->update([
                    'qty_barang'    => $totalQty,
                    'total_harga'   => $totalHarga,
                    'jumlah_barang' => $qtyBarang
                ]);
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Pembelian Berhasil'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Error Pembelian, ' . $err->getMessage());
            return response([
                'status'    => false,
                'message'   => 'Pembelian Gagal'
            ]);
        }
    }

    public function daftar_pembelian(): View
    {
        $result = Inbound::with('supplier')->where('type', 'pembelian')->get();

        $inbound = $result ?? [];

        $title = 'daftar pembelian';
        return view('inbound.daftar', compact('title', 'inbound'));
    }

    public function detail_pembelian($id)
    {
        $result = Inbound::with('supplier', 'inboundDetail', 'inboundDetail.barang')
            ->where('id', $id)
            ->first();

        $inbound = $result ?? [];

        $title = 'daftar pembelian';
        return view('inbound.detail', compact('title', 'inbound'));
    }

    public function return_pembelian(): View
    {
        $barang = BarangRusak::with('barang', 'barang.kategori')->get();
        $supplier = Supplier::all();

        $title = "return pembelian";
        return view('inbound.return', compact('title', 'barang', 'supplier'));
    }

    public function return_pembelian_post(Request $request)
    {
        try {
            DB::beginTransaction();
            $barang = $request->post('barang');
            $inbound = Inbound::create([
                'supplier_id'       => $request->post('supplier'),
                'po_number'         => 'RTN' . date('Ymd', time()) . rand(100, 1000),
                'no_invoice'        => null,
                'jumlah_barang'     => count($barang),
                'qty_barang'        => 0,
                'tanggal_datang'    => $request->post('tanggal_return'),
                'diskon_pembelian'  => null,
                'ppn'               => null,
                'total_harga'       => 0,
                'type'              => 'return'
            ]);

            $total_harga = 0;
            $jumlah_qty = 0;
            foreach ($barang as $b) {
                $inventory = Inventory::where('barang_id', $b['id'])->first();
                $inventoryDetail = InventoryDetail::where('inventory_id', $inventory->id)->orderBy('id', 'DESC')->first();
                InboundDetail::create([
                    'inbound_id'    => $inbound->id,
                    'barang_id'     => $b['id'],
                    'qty'           => $b['qty'],
                    'harga'         => $inventoryDetail->harga,
                    'diskon'        => 0,
                    'total_harga'   => $inventoryDetail->harga * $b['qty']
                ]);

                BarangRusak::where('barang_id', $b['id'])->decrement('stok', $b['qty']);

                $total_harga += $inventoryDetail->harga * $b['qty'];
                $jumlah_qty += $b['qty'];
            }

            Inbound::where('id', $inbound->id)->update([
                'qty_barang'    => $jumlah_qty,
                'total_harga'   => $total_harga
            ]);

            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Return Berhasil'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Error Return Pembelian, ' . $err->getMessage());
            return response([
                'status'    => false,
                'message'   => 'Return Gagal'
            ]);
        }
    }

    public function list_return_pembelian()
    {
        $result = Inbound::with('supplier')->where('type', 'return')->get();

        $inbound = $result ?? [];

        $title = 'list return pembelian';
        return view('inbound.list_return', compact('title', 'inbound'));
    }

    public function detail_return_pembelian($id)
    {
        $result = Inbound::with('supplier', 'inboundDetail', 'inboundDetail.barang')
            ->where('id', $id)
            ->first();

        $inbound = $result ?? [];

        $title = 'list return pembelian';
        return view('inbound.detail_return', compact('title', 'inbound'));
    }

    public function edit_pembelian($id)
    {
        $result = Inbound::with('supplier', 'inboundDetail', 'inboundDetail.barang')
            ->where('id', $id)
            ->first();

        $inbound = $result ?? [];

        $title = 'daftar pembelian';
        return view('inbound.edit', compact('title', 'inbound'));
    }
}
