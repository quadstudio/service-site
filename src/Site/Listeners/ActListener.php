<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use QuadStudio\Service\Site\Events\ActExport;

class ActListener
{


    /**
     * @param ActExport $event
     */
    public function onActSchedule(ActExport $event)
    {
        $event->act->schedules()->create([
            'action_id' => 3,
            'url' => preg_split("/:\/\//", route('api.acts.show', $event->act))[1]
        ]);
        //Schedule::create();
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
    }
}