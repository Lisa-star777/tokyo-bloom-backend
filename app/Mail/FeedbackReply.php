<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackReply extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $replyText;

    public function __construct($userName, $replyText)
    {
        $this->userName = $userName;
        $this->replyText = $replyText;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ответ на ваше сообщение',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback-reply',
        );
    }
}