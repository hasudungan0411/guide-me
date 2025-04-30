<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    use HasFactory;

    
    protected $table = 'wisatawan';
    protected $guard = 'wisatawan';
    protected $primaryKey = 'ID_Wisatawan';
    protected $fillable = [
        'Email',
        'Nama',
        'Kata_Sandi',
        'Nomor_HP'
    ];

}
