<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Wisatawan extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'wisatawan'; // Nama tabel di database
    protected $primaryKey = 'ID_Wisatawan'; // Primary key tabel wisatawan jika berbeda dari default 'id'

    protected $fillable = [
        'Email',
        'Nama',
        'Kata_Sandi',
        'Nomor_HP',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'Kata_Sandi' => 'hashed', // Untuk hashing password secara otomatis
    ];

    protected $hidden = [
        'Kata_Sandi', // Sembunyikan kata sandi dari array (misalnya saat ditampilkan)
    ];
}
