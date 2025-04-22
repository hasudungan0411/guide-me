<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login()
    {

    }

    public function showregister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'peran'    => 'required|in:wisatawan,pemilik_wisata',
            'nama_wisata'  => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->peran === 'wisatawan') {
            $user = Wisatawan::create([
                'Nama'     => $request->nama,
                'Email'    => $request->email,
                'Nomor_HP'   => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->kata_sandi)
            ]);
        } else {
            $user = PemilikWisata::create([
                'Email'    => $request->email,
                'Lokasi'    => $request->lokasi,
                'Nomor_HP'   => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->kata_sandi),
            ]);
        }

        return response()->json([
            'message' => 'User registered successfully as ' . $request->peran,
            'user'    => $user
        ], 201);
    }
}
