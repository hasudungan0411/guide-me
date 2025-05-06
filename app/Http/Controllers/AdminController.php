<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showlogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // mengambil username dan password dari env
        $adminusername = env('ADMIN_USERNAME');
        $adminpassword = env('ADMIN_PASSWORD');

        // cek input sesuai yg di env
        if ($request->username == $adminusername && $request->password == $adminpassword)
        {
            // cek apakah sudah ada didatabase
            $admin = DB::table('admin')->where('username', $adminusername)->first();

            if (!$admin)
            {
                // jika belum ada, simpan ke database
                DB::table('admin')->insert([
                    'username' => $adminusername,
                    'password' => $adminpassword,
                    'nama' => 'Admin_Guide-me',
                    'nomor_hp' => '087867529822',
                    'email' => 'tambunanrian@gmail.com'
                ]);
            }

            // simpan sesi login
            Session::put('admin', $admin);

            return redirect()->route('destinasi.index');
        } else {
            return back()->with('error', 'username dan password salah');
        }
    }

    public function logout() 
    {
        Session::forget('admin');
        return redirect()->route('admin.login')->with('Success', 'Logout berhasil');
    }
}
