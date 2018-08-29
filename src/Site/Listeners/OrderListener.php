<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use QuadStudio\Service\Site\Events\OrderExport;

class OrderListener
{


    /**
     * @param OrderExport $event
     */
    public function onOrderSchedule(OrderExport $event)
    {
        $event->order->schedules()->create([
            'action_id' => 2,
            'url' => preg_split("/:\/\//", route('api.orders.show', $event->order))[1]
        ]);
        //Schedule::create();
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            OrderExport::class,
            'QuadStudio\Service\Site\Listeners\OrderListener@onOrderSchedule'
        );
    }
}