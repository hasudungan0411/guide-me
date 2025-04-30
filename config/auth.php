<?php

return [

    'defaults' => [
        'guard' => 'wisatawan', // Default guard di sini
        'passwords' => 'wisatawan',
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
            'model' => App\Models\Wisatawan::class,
        ],
        'pemilik_wisata' => [
            'driver' => 'eloquent',
            'model' => App\Models\PemilikWisata::class,
        ],
    ],

    'passwords' => [
        'wisatawan' => [
            'provider' => 'wisatawan',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'pemilikwisata' => [
            'provider' => 'pemilikwisata',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
