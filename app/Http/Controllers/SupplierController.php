<?php

namespace App\Http\Controllers;

use App\Models\Inbound;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $data = Supplier::all();
        $supplier = $data ?? [];

        $title = "supplier";
        return view("supplier.supplier", compact("title", "supplier"));
    }

    public function tambah_supplier(Request $request)
    {
        Supplier::create([
            'nama'  => $request->post('nama'),
            'no_hp' => $request->post('no_hp')
        ]);

        Session::flash('success', 'Tambah Supplier Berhasil');
        return back();
    }

    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();

        $title = "supplier";
        return view("supplier.edit", compact("title", "supplier"));
    }

    public function edit_supplier(Request $request)
    {
        Supplier::where('id', $request->post('id'))->update([
            'nama'  => $request->post('nama'),
            'no_hp' => $request->post('no_hp')
        ]);

        Session::flash('success', 'Edit Supplier Berhasil');
        return back();
    }

    public function hapus($id)
    {
        $check = Inbound::where('supplier_id', $id)->count();

        if ($check != 0) {
            Session::flash('error', 'Hapus Supplier Gagal, Supplier telah dipakai oleh transaksi');
        } else {
            Supplier::where('id', $id)->delete();
            Session::flash('success', 'Hapus Supplier Berhasil');
        }

        return back();
    }
}
