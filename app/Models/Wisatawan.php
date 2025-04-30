<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Wisatawan extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    
    protected $table = 'wisatawan';
    protected $guard = 'wisatawan';
    protected $fillable = [
        'Email',
        'Nama',
        'Kata_Sandi',
        'Nomor_HP'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'Kata_Sandi' => 'hashed',
    ];

    protected $hidden = [
        'Kata_Sandi',
    ];

}
