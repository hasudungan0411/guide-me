<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';

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

<<<<<<< HEAD
    public function favoritwisatawan()
    {
        return $this->belongsTo(Wisatawan::class,'favorit','destination_id','wisatawan_id');
    }
=======
    public function tiket()
{
    return $this->hasMany(Tiket::class, 'ID_Wisata', 'id');
}
>>>>>>> bb32160fe2f613b3620420b56125ee17eba18f3a
}
