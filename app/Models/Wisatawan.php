<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Wisatawan extends Authenticatable
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
        'Kata_Sandi' => 'hashed', // Untuk hashing password secara otomatis
    ];

    protected $hidden = [
        'Kata_Sandi', // Sembunyikan kata sandi dari array (misalnya saat ditampilkan)
    ];
}
