<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\OrderCreateEvent;
use QuadStudio\Service\Site\Events\OrderScheduleEvent;
use QuadStudio\Service\Site\Mail\Admin\Order\OrderCreateEmail;

class OrderListener
{


    /**
     * @param OrderScheduleEvent $event
     */
    public function onOrderSchedule(OrderScheduleEvent $event)
    {
        $event->order->schedules()->create([
            'action_id' => 2,
            'url'       => preg_split("/:\/\//", route('api.orders.show', $event->order))[1]
        ]);
        $event->order->setAttribute('status_id', 2);
        $event->order->save();
        //Schedule::create();
    }

    /**
     * @param OrderCreateEvent $event
     */
    public function onOrderCreate(OrderCreateEvent $event)
    {
        // Отправка администратору письма об офромлении нового заказа
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new OrderCreateEmail($event->order));
    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            OrderCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\OrderListener@onOrderCreate'
        );

        $events->listen(
            OrderScheduleEvent::class,
            'QuadStudio\Service\Site\Listeners\OrderListener@onOrderSchedule'
        );
    }
}