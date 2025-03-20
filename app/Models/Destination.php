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
        'kategori',
        'desk',
        'long_desk',
        'click_count',
    ];
}
