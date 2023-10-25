<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangRusak;
use App\Models\InboundDetail;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function oli(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 1)->orderBy('nama_barang', 'ASC')->get();

        $barang = $data ?? [];

        $title = "oli";
        return view('barang.oli', compact("title", "barang"));
    }

    public function ban(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 2)->orderBy('nama_barang', 'ASC')->get();

        $barang = $data ?? [];

        $title = "ban";
        return view('barang.ban', compact("title", "barang"));
    }

    public function sparepart(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 3)->orderBy('nama_barang', 'ASC')->get();

        $barang = $data ?? [];

        $title = "sparepart";
        return view('barang.sparepart', compact("title", "barang"));
    }

    public function find(Request $request)
    {
        return Barang::where('id', $request->get('barang_id'))->first();
    }

    public function findBarangRusak(Request $request)
    {
        return BarangRusak::with('barang')->where('barang_id', $request->get('barang_id'))->first();
    }

    public function barang_rusak()
    {
        $dataBarangRusak = BarangRusak::with('supplier', 'barang')->get();

        $barangRusak = $dataBarangRusak ?? [];

        $title = "barang rusak";
        return view('barang.rusak', compact('title', 'barangRusak'));
    }

    public function download_list_barang($kategori)
    {
        if ($kategori == "oli") {
            $dataBarang = Barang::with('inventory')->where('kategori_id', 1)->get();
            $title = "OLI";
        } elseif ($kategori == "ban") {
            $dataBarang = Barang::with('inventory')->where('kategori_id', 2)->get();
            $title = "BAN";
        } else {
            $dataBarang = Barang::with('inventory')->where('kategori_id', 3)->get();
            $title = "SPAREPART";
        }

        $barang = $dataBarang ?? [];

        $pdf = Pdf::loadView('pdf.list_barang', ['barang' => $barang, 'title' => $title]);
        return $pdf->stream('list-barang-'.$kategori.'.pdf');
    }

    public function detail_barang($id)
    {
        $dataBarang = Barang::with('kategori', 'inventory')->where('id', $id)->first();

        $barang = $dataBarang ?? [];

        $title = $dataBarang->kategori->nama;
        return view('barang.detail', compact('title', 'barang'));
    }

    public function edit_barang($id)
    {
        $kategori = Kategori::all();
        $dataBarang = Barang::with('kategori', 'inventory')->where('id', $id)->first();

        $barang = $dataBarang ?? [];

        $title = $dataBarang->kategori->nama;
        return view('barang.edit', compact('title', 'barang', 'kategori'));
    }

    public function edit_barang_post(Request $request)
    {
        Barang::where('id', $request->post('barang_id'))->update([
            'nama_barang'   => $request->post('nama_barang'),
            'kategori_id'   => $request->post('kategori'),
            'harga_umum'    => $request->post('harga_umum'),
            'harga_sales'   => $request->post('harga_sales')
        ]);

        Session::flash('success', 'Edit Barang Berhasil');
        return back();
    }

    public function hapus_barang($id)
    {
        $check = InboundDetail::where('barang_id', $id)->count();
        if ($check != 0) {
            Session::flash('error', 'Barang Sudah dilakukan pembelian, tidak dapat dihapus');
            return back();
        }
        Barang::where('id', $id)->delete();
        Session::flash('success', 'Barang berhasil dihapus');
        return back();
    }
}
