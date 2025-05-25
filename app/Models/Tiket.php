<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tiket';
    protected $primaryKey = 'ID_Tiket';
    public $timestamps = false; 

    protected $fillable = [
        'ID_Wisata',
        'ID_Pemilik',
        'Persediaan',
        'Harga',
    ];

    public function pemilikwisata()
    {
        return $this->belongsTo(Pemilikwisata::class, 'ID_Pemilik', 'ID_Pemilik_Wisata');
    }

    public function destinasi()
    {
        return $this->belongsTo(Destination::class, 'ID_Wisata', 'id'); 
    }
    
}