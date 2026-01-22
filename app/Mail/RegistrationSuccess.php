<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    // Terima data pendaftaran saat class dipanggil
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tiket Event: ' . $this->registration->event->title,
        );
    }

    public function content(): Content
    {
        // Kita akan buat view ini di langkah selanjutnya
        return new Content(
            view: 'emails.registration_success',
        );
    }
}