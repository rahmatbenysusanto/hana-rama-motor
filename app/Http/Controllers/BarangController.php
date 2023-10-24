<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangRusak;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function oli(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 1)->get();

        $barang = $data ?? [];

        $title = "oli";
        return view('barang.oli', compact("title", "barang"));
    }

    public function ban(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 2)->get();

        $barang = $data ?? [];

        $title = "ban";
        return view('barang.ban', compact("title", "barang"));
    }

    public function sparepart(): View
    {
        $data = Barang::with('inventory')->where('kategori_id', 3)->get();

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
}
