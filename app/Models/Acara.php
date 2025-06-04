<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;

class Acara extends Model
{
    use HasFactory;

    protected $table = 'acara';
    protected $primaryKey = 'ID_Acara';

    protected $fillable = [
        'ID_Wisata',
        'Tanggal_mulai_acara',
        'Tanggal_berakhir_acara',
        'Nama_acara',
        'Deskripsi'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
