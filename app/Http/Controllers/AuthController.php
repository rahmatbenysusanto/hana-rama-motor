<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'name'      => 'required',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::select([
                    'id',
                    'name',
                    'role'
                ])
                ->where('name', $request->post('name'))
                ->first();
            Session::put('data_user', $user);

            return redirect()->action([DashboardController::class, 'index']);
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return back();
        }
    }

    public function logout()
    {
        Session::forget('data_user');
        return view('login');
    }
}
