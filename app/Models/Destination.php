<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';
    public $timestamps = false;

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'latitude',
        'longitude',
        'tujuan',
        'gambar',
        'gambar2',
        'gambar3',
        'gambar4',
        'gambar5',
        'gambarM',
        'kategori_id',
        'desk',
        'long_desk',
        'click_count',
    ];


    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id', 'id_kategori');
    }

    public function acara()
    {
        return $this->hasMany(Acara::class, 'ID_Wisata');
    }

    public function pemilikwisata()
    {
        return $this->hasOne(Pemilikwisata::class, 'Nama_Wisata', 'tujuan');
    }

    public function favoritwisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'favorit', 'destination_id', 'wisatawan_id');
    }
    public function tiket()
    {
        return $this->hasOne(Tiket::class, 'ID_Wisata', 'id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'destinations_id');
    }

}
