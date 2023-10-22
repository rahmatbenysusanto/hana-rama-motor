<?php

namespace App\Http\Controllers;

use App\Models\Inbound;
use App\Models\Sales;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SalesController extends Controller
{
    public function index(): View
    {
        $data = Sales::all();
        $sales = $data ?? [];

        $title = "sales";
        return view("sales.sales", compact("title", "sales"));
    }

    public function tambah_sales(Request $request)
    {
        Sales::create([
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
            'type'      => $request->post('type'),
            'nominal'   => $request->post('nominal')
        ]);

        Session::flash('success', 'Tambah Sales Berhasil');
        return back();
    }

    public function edit($id)
    {
        $sales = Sales::where('id', $id)->first();

        $title = "sales";
        return view("sales.edit", compact("title", "sales"));
    }

    public function edit_sales(Request $request)
    {
        Sales::where('id', $request->post('id'))->update([
            'nama'  => $request->post('nama'),
            'no_hp' => $request->post('no_hp'),
            'type'      => $request->post('type'),
            'nominal'   => $request->post('nominal')
        ]);

        Session::flash('success', 'Edit Sales Berhasil');
        return back();
    }

    public function hapus($id)
    {
        $check = Transaksi::where('sales_id', $id)->count();

        if ($check != 0) {
            Session::flash('error', 'Hapus Sales Gagal, Sales telah dipakai oleh transaksi');
        } else {
            Sales::where('id', $id)->delete();
            Session::flash('success', 'Hapus Sales Berhasil');
        }

        return back();
    }
}
