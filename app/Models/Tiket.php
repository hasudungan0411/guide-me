<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tiket';
    protected $primaryKey = 'ID_Tiket';
    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'ID_Wisata',
        'ID_Wisatawan',
        'Persediaan',
        'Harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id', 'id_kategori');
    }

    public function acara()
    {
        return $this->hasMany(Acara::class, 'destination_id');
    }

    public function pemilikwisata()
    {
        return $this->hasOne(Pemilikwisata::class, 'Nama_Wisata', 'tujuan');
    }
}
