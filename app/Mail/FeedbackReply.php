<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackReply extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $replyText;

    public function __construct($name, $replyText)
    {
        $this->name = $name;
        $this->replyText = $replyText;
    }

    public function build()
    {
        return $this->from('tokyobloom@mail.ru', 'Tokyo Bloom')
                    ->subject('Ответ на ваше сообщение')
                    ->view('emails.feedback-reply')
                    ->with([
                        'name' => $this->name,
                        'replyText' => $this->replyText,
                    ]);
    }
}
