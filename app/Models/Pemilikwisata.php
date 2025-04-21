<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilikwisata extends Model
{
    use HasFactory;

    protected $table = 'pemilik_wisata';

    protected $fillable = [
        'Email',
        'Kata_Sandi',
        'Nomor_HP',
        'Nama_Wisata',
        'Lokasi'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'tujuan', 'nama_wisata');
    }
}

