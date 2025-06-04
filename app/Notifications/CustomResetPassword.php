<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification; // Import the original

class CustomResetPassword extends ResetPasswordNotification // Extend the original
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false)); // Gunakan false untuk absolute URL jika tidak ingin domain dari APP_URL

        return (new MailMessage)
                    ->subject('Reset Kata Sandi Akun Anda') // Subjek email
                    ->view('emails.reset_password_custom', [ // Ganti dengan path template Anda
                        'subject' => 'Reset Kata Sandi Akun Anda',
                        'mailMessage' => 'Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.',
                        'resetLink' => $url,
                        'email' => $notifiable->getEmailForPasswordReset(), // Tambahkan ini jika dibutuhkan di template
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
