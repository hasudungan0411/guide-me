<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Messages\MailMessage;

class Wisatawan extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $table = 'wisatawan';
    protected $primaryKey = 'ID_Wisatawan';

    protected $fillable = [
        'Email',
        'Nama',
        'Kata_Sandi',
        'Nomor_HP',
        'Foto_Profil',
        'email_verified_at',
    ];

    protected $hidden = [
        'Kata_Sandi',
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

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'wisatawan_id');
    }

    public function routeNotificationForMail()
    {
        return $this->Email;
    }

    public function sendPasswordResetNotification($token)
    {
        // Buat URL reset password
        $url = route('wisatawan.password.reset', [
            'token' => $token,
            'email' => $this->Email,
        ]);

        // Kirim email menggunakan MailMessage
        $this->notify(new class($url) extends \Illuminate\Auth\Notifications\ResetPassword {
            public $url;

            public function __construct($url)
            {
                $this->url = $url;
            }

            public function toMail($notifiable)
            {
                return (new MailMessage)
                            ->subject('Link untuk Mengatur Ulang Kata Sandi Anda') // Subjek email kustom
                            ->view('wisatawan.password.proses-email', [
                                'url' => $this->url,
                                'namaPengguna' => $notifiable->Nama,
                                'emailPengguna' => $notifiable->Email,
                            ]);
            }
        });
    }
}
