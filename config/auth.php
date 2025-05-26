<?php

return [

    'defaults' => [
        'guard' => 'wisatawan', // Default guard di sini
        'passwords' => 'wisatawan', // Default password reset untuk wisatawan
    ],

    'guards' => [
        'wisatawan' => [
            'driver' => 'session',
            'provider' => 'wisatawans',
        ],
        'pemilikwisatas' => [
            'driver' => 'session',
            'provider' => 'pemilikwisatas',
        ],
    ],


    'providers' => [
        'wisatawans' => [
            'driver' => 'eloquent',
            'model' => App\Models\Wisatawan::class,
        ],
        'pemilikwisatas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pemilikwisata::class,
        ],
    ],


    'passwords' => [
        'wisatawan' => [
            'provider' => 'wisatawans',
            'table' => 'password_resets', // Tabel password reset untuk wisatawan
            'expire' => 60,  // Expired setelah 1 jam
            'throttle' => 60, // Batasi percobaan pengiriman reset password
        ],

        'pemilik_wisata' => [
            'provider' => 'pemilikwisatas',
            'table' => 'password_resets', // Tabel password reset untuk pemilik wisata
            'expire' => 60,  // Expired setelah 1 jam
            'throttle' => 60, // Batasi percobaan pengiriman reset password
        ],
    ],

    'password_timeout' => 10800, // Waktu logout otomatis setelah 3 jam
];
