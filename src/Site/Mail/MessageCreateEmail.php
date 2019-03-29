<?php

namespace QuadStudio\Service\Site\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Message;

class MessageCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Message
     */
    public $mail_message;

    /**
     * Create a new message instance.
     * @param Message $message
     */
    public function __construct(Message $mail_message)
    {
        $this->mail_message = $mail_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::message.email.title'))
            ->view('site::email.message.create');
    }
}
