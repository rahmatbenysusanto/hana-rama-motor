<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
        $barang = Barang::where('id', $request->get('barang_id'))->first();
        return $barang;
    }
}
