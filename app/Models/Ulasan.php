<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'ulasan';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'destinations_id',
        'wisatawan_id',
        'ulasan',
        'rating',
    ];

    // Relasi dengan tabel Wisatawan
    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'wisatawan_id');
    }

    // Relasi dengan tabel Destinations
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destinations_id');
    }
}
