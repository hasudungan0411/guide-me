<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'gambar',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'kategori_id', 'id_kategori');
    }
}
