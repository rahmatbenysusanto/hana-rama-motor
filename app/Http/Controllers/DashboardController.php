<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $title = "dashboard utama";
        return view('dashboard.index', compact("title"));
    }
}
