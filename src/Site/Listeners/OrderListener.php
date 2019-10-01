<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\OrderPricesAgreedEvent;
use QuadStudio\Service\Site\Events\OrderStatusChangeEvent;
use QuadStudio\Service\Site\Events\OrderCreateEvent;
use QuadStudio\Service\Site\Events\OrderScheduleEvent;
use QuadStudio\Service\Site\Events\OrderUserConfirmEvent;
use QuadStudio\Service\Site\Mail\Order\AdminOrderConfirmEmail;
use QuadStudio\Service\Site\Mail\User\Order\OrderStatusChangeEmail;
use QuadStudio\Service\Site\Mail\Order\UserOrderCreateEmail;
use QuadStudio\Service\Site\Mail\Order\AdminOrderCreateEmail;
use QuadStudio\Service\Site\Mail\User\Order\OrderScheduleEmail as UserOrderScheduleEmail;

class OrderListener
{


	/**
	 * @param OrderScheduleEvent $event
	 */
	public function onOrderSchedule(OrderScheduleEvent $event)
	{
		$event->order->schedules()->create([
			'action_id' => 2,
			'url' => preg_split("/:\/\//", route('api.orders.show', $event->order))[1],
		]);
		$event->order->setAttribute('status_id', 2);
		$event->order->save();
		Mail::to($event->order->user->email)->send(new UserOrderScheduleEmail($event->order));
	}

	/**
	 * @param OrderCreateEvent $event
	 */
	public function onOrderCreate(OrderCreateEvent $event)
	{
		Mail::to(env('MAIL_TO_ADDRESS'))->send(new AdminOrderCreateEmail($event->order));

		if ($event->order->user->email) {
			Mail::to($event->order->user->email)->send(new UserOrderCreateEmail($event->order));
		}

        if($event->order->address->email){
            Mail::to($event->order->address->email)->send(new UserOrderCreateEmail($event->order));
        }
	}

	/**
	 * @param OrderStatusChangeEvent $event
	 */
	public function onOrderStatusChange(OrderStatusChangeEvent $event)
	{
		Mail::to($event->order->user->email)->send(new OrderStatusChangeEmail($event->order));

		if ($event->order->getAttribute('status_id') == 9) {
			$event->order->recalculate();
		}
	}

	/**
	 * @param OrderUserConfirmEvent $event
	 */
	public function onOrderConfirmed(OrderUserConfirmEvent $event)
	{
		Mail::to(env('MAIL_ORDER_ADDRESS'))->send(new AdminOrderConfirmEmail($event->order));
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
			OrderStatusChangeEvent::class,
			'QuadStudio\Service\Site\Listeners\OrderListener@onOrderStatusChange'
		);

		$events->listen(
			OrderScheduleEvent::class,
			'QuadStudio\Service\Site\Listeners\OrderListener@onOrderSchedule'
		);

		$events->listen(
			OrderUserConfirmEvent::class,
			'QuadStudio\Service\Site\Listeners\OrderListener@onOrderConfirmed'
		);

	}
}