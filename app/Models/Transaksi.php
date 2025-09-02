<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
        use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'ID_Transaksi';
    public $timestamps = false; 

    protected $fillable = [
        'ID_Tiket',
        'ID_Wisata',
        'ID_Wisatawan',
        'Status',
        'total_harga',
        'Jumlah_Tiket',
        'Tanggal_Transaksi',
        'Tanggal_Tiket',
        'Bukti_Transaksi',
        'snap_token'
    ];

    public function destinasi()
    {
        return $this->belongsTo(Destination::class, 'ID_Wisata', 'id'); 
    }
    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'ID_Wisatawan', 'ID_Wisatawan'); 
    }
}
