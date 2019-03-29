<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\MessageCreateEvent;
use QuadStudio\Service\Site\Mail\MessageCreateEmail;

class MessageListener
{

    /**
     * @param MessageCreateEvent $event
     */
    public function onMessageCreate(MessageCreateEvent $event)
    {

        // Отправка получателю уведомления о новом сообщении
        Mail::to($event->message->receiver->email)->send(new MessageCreateEmail($event->message));

    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            MessageCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\MessageListener@onMessageCreate'
        );

    }
}