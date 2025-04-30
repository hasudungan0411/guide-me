<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemilikwisata extends Authenticatable
{
    use HasFactory;

    protected $table = 'pemilik_wisata';
    protected $primaryKey = 'ID_Pemilik_Wisata';
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
