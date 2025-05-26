<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Wisatawan extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $table = 'wisatawan'; // Nama tabel di database
    protected $primaryKey = 'ID_Wisatawan'; // Primary key tabel wisatawan jika berbeda dari default 'id'

    protected $fillable = [
        'Email',
        'Nama',
        'Kata_Sandi',
        'Nomor_HP',
        'Foto_Profil',
    ];

    protected $hidden = [
        'Kata_Sandi', // Sembunyikan kata sandi dari array (misalnya saat ditampilkan)
    ];

    public function getAuthPassword()
    {
        return $this->Kata_Sandi;
    }

    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }

    public function favorit()
    {
        return $this->belongsToMany(Destination::class, 'favorit', 'wisatawan_id', 'destination_id');
    }
}
