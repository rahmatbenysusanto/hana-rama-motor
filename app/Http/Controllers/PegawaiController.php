<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
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
}
