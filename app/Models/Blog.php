<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $primaryKey = 'id_blog';

    protected $fillable = [
        'kategori_id',
        'judul',
        'short_desk',
        'deskripsi',
        'gambar',
        'tanggal',
        'slug'
    ];

    protected $casts = [
        'tanggal' => 'datetime', # casting tanggal
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id', 'id_kategori');
    }
}
