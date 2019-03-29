<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\MountingCreateEvent;
use QuadStudio\Service\Site\Events\MountingStatusChangeEvent;
use QuadStudio\Service\Site\Mail\Admin\Mounting\MountingCreateEmail;
use QuadStudio\Service\Site\Mail\User\Mounting\MountingStatusChangeEmail;

class MountingListener
{

    /**
     * @param MountingCreateEvent $event
     */
    public function onMountingCreate(MountingCreateEvent $event)
    {

        // Отправка получателю уведомления о новом отчете по монтажу
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new MountingCreateEmail($event->mounting));

    }

    /**
     * @param MountingStatusChangeEvent $event
     */
    public function onMountingStatusChange(MountingStatusChangeEvent $event)
    {

        // Отправка пользователю уведомления о смене статуса отчета по монтажу
        Mail::to($event->mounting->user->email)->send(new MountingStatusChangeEmail($event->mounting));

    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            MountingCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\MountingListener@onMountingCreate'
        );

        $events->listen(
            MountingStatusChangeEvent::class,
            'QuadStudio\Service\Site\Listeners\MountingListener@onMountingStatusChange'
        );

    }
}