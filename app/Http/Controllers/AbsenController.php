<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Pegawai;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AbsenController extends Controller
{
    public function absen(): View
    {
        $bulan = date('m', time());
        $tahun = date('Y', time());

        $sales = Pegawai::all();

        $data = [];
        foreach ($sales as $sa) {
            $masuk = Absen::where('pegawai_id', $sa->id)
                ->where('absen', 'masuk')
                ->WhereMonth('tanggal_absen', $bulan)
                ->whereYear('tanggal_absen', $tahun)
                ->count();

            $tidak = Absen::where('pegawai_id', $sa->id)
                ->where('absen', 'tidak masuk')
                ->WhereMonth('tanggal_absen', $bulan)
                ->whereYear('tanggal_absen', $tahun)
                ->count();

            $data[] = [
                'id'    => $sa->id,
                'nama'  => $sa->nama,
                'no_hp' => $sa->no_hp,
                'masuk' => $masuk,
                'tidak' => $tidak
            ];
        }

        $title = "absen";
        return view('absen.absen', compact('title', 'data'));
    }

    public function buat_absen(Request $request)
    {
        Absen::create([
            'pegawai_id'    => $request->post('pegawai_id'),
            'absen'         => $request->post('jenis'),
            'keterangan'    => $request->post('keterangan'),
            'tanggal_absen' => $request->post('tanggal'),
        ]);

        Session::flash('success', 'Buat Absensi Berhasil');

        return back();
    }

    public function lihat_absen($pegawai_id)
    {
        $absen = Absen::where('pegawai_id', $pegawai_id)->orderBy('tanggal_absen', 'DESC')->get();

        $title = "absen";
        return view('absen.lihat', compact('title', 'absen'));
    }
}
