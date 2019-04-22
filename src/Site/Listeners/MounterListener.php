<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\MounterCreateEvent;
use QuadStudio\Service\Site\Mail\Mounter\AdminMounterCreateEmail;
use QuadStudio\Service\Site\Mail\Mounter\UserMounterCreateEmail;

class MounterListener
{

    /**
     * @param MounterCreateEvent $event
     */
    public function onMounterCreate(MounterCreateEvent $event)
    {

        // Отправка администратору уведомления о новой заявке на монтаж
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new AdminMounterCreateEmail($event->mounter));

        if ($event->mounter->userAddress->email) {

            // Отправка СЦ уведомления о новой заявке на монтаж
            Mail::to($event->mounter->userAddress->email)->send(new UserMounterCreateEmail($event->mounter));
        }

    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            MounterCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\MounterListener@onMounterCreate'
        );


    }
}