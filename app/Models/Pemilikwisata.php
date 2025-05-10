<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Pemilikwisata extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'pemilik_wisata';
    protected $primaryKey = 'ID_Pemilik_Wisata';
    protected $fillable = [
        'Email',
        'Kata_Sandi',
        'Nomor_HP',
        'Nama_Wisata',
        'Lokasi'
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
