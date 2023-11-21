<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengaturanController extends Controller
{
    public function index()
    {
        $data = Pengaturan::all();

        $title = "pengaturan";
        return view('pengaturan.index', compact('title', 'data'));
    }

    public function ubah_pengaturan(Request $request)
    {
        $result = Pengaturan::where('id', $request->id)->first();

        if ($result->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        Pengaturan::where('id', $request->id)->update([
            'status'    => $status
        ]);

        // Barang
        if ($request->id == 1) {
            if ($status == 1) {
                Session::put('pengaturanBarang', 1);
            } else {
                Session::put('pengaturanBarang', 0);
            }
        }

        return true;
    }
}
