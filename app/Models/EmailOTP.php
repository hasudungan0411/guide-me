<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOTP extends Model
{
    protected $table = "otp_email";
    protected $primaryKey = 'id';
    protected $fillable = ['email_wisatawan', 'otp', 'expires_at'];
    public $timestamps = false;

    protected $dates = ['expires_at'];
}
