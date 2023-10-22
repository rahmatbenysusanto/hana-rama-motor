<?php

namespace App\Http\Controllers;

use App\Models\Inbound;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index(): View
    {
        $data = Pelanggan::all();
        $pelanggan = $data ?? [];

        $title = "pelanggan";
        return view("pelanggan.pelanggan", compact("title", "pelanggan"));
    }

    public function tambah_pelanggan(Request $request)
    {
        Pelanggan::create([
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
            'alamat'    => $request->post('alamat')
        ]);

        Session::flash('success', 'Tambah Pelanggan Berhasil');
        return back();
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::where('id', $id)->first();

        $title = "pelanggan";
        return view("pelanggan.edit", compact("title", "pelanggan"));
    }

    public function edit_pelanggan(Request $request)
    {
        Pelanggan::where('id', $request->post('id'))->update([
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
            'alamat'    => $request->post('alamat')
        ]);

        Session::flash('success', 'Edit Pelanggan Berhasil');
        return back();
    }

    public function hapus($id)
    {
        $check = Transaksi::where('pelanggan_id', $id)->count();

        if ($check != 0) {
            Session::flash('error', 'Hapus Pelanggan Gagal, Pelanggan telah dipakai oleh transaksi');
        } else {
            Pelanggan::where('id', $id)->delete();
            Session::flash('success', 'Hapus Pelanggan Berhasil');
        }

        return back();
    }
}
