<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Websitemail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $subject;
    public $resetLink;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $subject, $resetLink)
    {
        $this->mailMessage = $message;
        $this->subject = $subject;
        $this->resetLink = $resetLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'wisatawan.welcome-email',  // Pastikan ini mengarah ke view yang benar
            with: [
                'mailMessage' => $this->mailMessage,
                'resetLink' => $this->resetLink,  // Menambahkan reset link ke view
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
