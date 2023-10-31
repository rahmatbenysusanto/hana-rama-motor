<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function laporan_transaksi():View
    {
        $dataSales = Sales::all();

        $sales = $dataSales ?? [];

        $title = "laporan transaksi";
        return view('laporan.list_sales', compact('title', 'sales'));
    }
}
