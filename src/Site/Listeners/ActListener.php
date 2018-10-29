<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\ActCreateEvent;
use QuadStudio\Service\Site\Events\ActExport;
use QuadStudio\Service\Site\Mail\User\Act\ActCreateEmail;

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
     * @param ActCreateEvent $event
     */
    public function onActCreate(ActCreateEvent $event)
    {
        // Отправка пользователю письма о том, что созданы АВР
        Mail::to($event->user->email)->send(new ActCreateEmail($event->user, $event->acts));
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
            ActCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\ActListener@onActCreate'
        );
    }
}