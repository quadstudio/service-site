<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\FeedbackCreateEvent;
use QuadStudio\Service\Site\Mail\FeedbackEmail;

class FeedbackListener
{

    /**
     * @param FeedbackCreateEvent $event
     */
    public function onFeedbackCreate(FeedbackCreateEvent $event)
    {
        // Отправка письма о новом сообщении с сайта
        Mail::to(env('MAIL_INFO_ADDRESS'))->send(new FeedbackEmail($event->data));
    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            FeedbackCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\FeedbackListener@onFeedbackCreate'
        );
    }
}