<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\ActMountingCreateEvent;
use QuadStudio\Service\Site\Events\ActRepairCreateEvent;
use QuadStudio\Service\Site\Events\ActExport;
use QuadStudio\Service\Site\Mail\User\Act\ActRepairCreateEmail;
use QuadStudio\Service\Site\Mail\User\Act\AdminActMountingCreateEmail;

class ActListener
{


    /**
     * @param ActExport $event
     */
    public function onActSchedule(ActExport $event)
    {
        $event->act->schedules()->create([
            'action_id' => 3,
            'url'       => preg_split("/:\/\//", route('api.acts.show', $event->act))[1]
        ]);
        //Schedule::create();
    }

    /**
     * @param ActRepairCreateEvent $event
     */
    public function onActRepairCreate(ActRepairCreateEvent $event)
    {
        // Отправка пользователю письма о том, что созданы АВР
        Mail::to($event->user->email)->send(new ActRepairCreateEmail($event->user, $event->acts));
    }

    /**
     * @param ActRepairCreateEvent $event
     */
    public function onActMountingCreate(ActMountingCreateEvent $event)
    {
        // Отправка администратору уведомления о создании нового АВР по монтажам
        Mail::to($event->user->email)->send(new AdminActMountingCreateEmail($event->user, $event->acts));
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            ActExport::class,
            'QuadStudio\Service\Site\Listeners\ActListener@onActSchedule'
        );

        $events->listen(
            ActRepairCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\ActListener@onActRepairCreate'
        );

        $events->listen(
            ActMountingCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\ActListener@onActMountingCreate'
        );
    }
}