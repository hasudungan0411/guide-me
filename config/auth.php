<?php

return [

    'defaults' => [
        'guard' => 'wisatawan', // Default guard di sini
        'passwords' => 'wisatawan', // Default password reset untuk wisatawan
    ],

    'guards' => [
        'wisatawan' => [
            'driver' => 'session',
            'provider' => 'wisatawan',
        ],

        'pemilik_wisata' => [
            'driver' => 'session',
            'provider' => 'pemilik_wisata',
        ],
    ],

    'providers' => [
        'wisatawan' => [
            'driver' => 'eloquent',
            'model' => App\Models\Wisatawan::class, // Pastikan model Wisatawan sudah ada
        ],

        'pemilik_wisata' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pemilikwisata::class, // Pastikan model Pemilikwisata sudah ada
        ],
    ],

    'passwords' => [
        'wisatawan' => [
            'provider' => 'wisatawan',
            'table' => 'password_resets', // Tabel password reset untuk wisatawan
            'expire' => 60,  // Expired setelah 1 jam
            'throttle' => 60, // Batasi percobaan pengiriman reset password
        ],

        'pemilik_wisata' => [
            'provider' => 'pemilik_wisata',
            'table' => 'password_resets', // Tabel password reset untuk pemilik wisata
            'expire' => 60,  // Expired setelah 1 jam
            'throttle' => 60, // Batasi percobaan pengiriman reset password
        ],
    ],

    'password_timeout' => 10800, // Waktu logout otomatis setelah 3 jam
];
