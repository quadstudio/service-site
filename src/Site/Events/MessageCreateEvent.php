<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Message;

class MessageCreateEvent
{
    use SerializesModels;

    /**
     * Заявка на авторизацию
     *
     * @var Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}
