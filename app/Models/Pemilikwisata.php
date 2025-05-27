<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PemilikVerifyEmail;

class Pemilikwisata extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pemilik_wisata';
    protected $primaryKey = 'ID_Pemilik_Wisata';
    protected $fillable = [
        'Email',
        'Kata_Sandi',
        'Nomor_HP',
        'Nama_Wisata',
        'Lokasi',
        'Nomor_Rekening',
        'Qris',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'Kata_Sandi',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'Nama_Wisata', 'tujuan');
    }
    

    public function getEmailForVerification()
    {
        return $this->Email;
    }

    public function getAuthPassword()
    {
        return $this->Kata_Sandi;
    }


}
