<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemilikwisata extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    protected $table = 'pemilik_wisata';
<<<<<<< HEAD
    protected $guard = 'pemilik_wisata';
    protected $primaryKey = 'ID_Pemilik_Wisata';
=======

    protected $guard = 'pemilik_wisata';

>>>>>>> e85c0c8fc7ed4c07599dd37703c0e7f6d0794de3
    protected $fillable = [
        'Email',
        'Kata_Sandi',
        'Nomor_HP',
        'Nama_Wisata',
        'Lokasi'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'Kata_Sandi' => 'hashed',
    ];

    protected $hidden = [
        'Kata_Sandi',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'tujuan', 'nama_wisata');
    }
}

