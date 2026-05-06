<?php

namespace App\Mail;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;
    public $user;

    public function __construct(Certificate $certificate, User $user)
    {
        $this->certificate = $certificate;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваш подарочный сертификат Tokyo Bloom',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-created',
        );
    }
}