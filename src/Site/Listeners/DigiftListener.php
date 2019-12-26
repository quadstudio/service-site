<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\Digift\ExceptionEvent;
use QuadStudio\Service\Site\Events\Digift\ExpenseApiExceptionEvent;
use QuadStudio\Service\Site\Events\Digift\UserBalanceMismatchEvent;
use QuadStudio\Service\Site\Mail\Admin\Digift\ApiErrorEmail;
use QuadStudio\Service\Site\Mail\Admin\Digift\ExceptionEmail;
use QuadStudio\Service\Site\Mail\Admin\Digift\UserBalanceMismatchEmail;

class DigiftListener
{

	/**
	 * @param UserBalanceMismatchEvent $event
	 */
	public function onUserBalanceMismatch(UserBalanceMismatchEvent $event)
	{
		Mail::to(env('MAIL_BONUS_ADDRESS'))
			->cc(env('MAIL_DIRECTOR_ADDRESS '))
			->send(new UserBalanceMismatchEmail($event->digiftUser, $event->balance));
		//TODO Раскомментить

	}

	/**
	 * @param ExpenseApiExceptionEvent $event
	 */
	public function onDigiftApiError(ExpenseApiExceptionEvent $event)
	{
		Mail::to(env('MAIL_BONUS_ADDRESS'))
			->send(new ApiErrorEmail($event->request_data, $event->exception));
	}

	/**
	 * @param ExceptionEvent $event
	 */
	public function onException(ExceptionEvent $event)
	{
		Mail::to(env('MAIL_BONUS_ADDRESS'))
			->send(new ExceptionEmail($event->method, $event->exception));
	}

	/**
	 * @param Dispatcher $events
	 */
	public function subscribe(Dispatcher $events)
	{

		$events->listen(
			UserBalanceMismatchEvent::class,
			'QuadStudio\Service\Site\Listeners\DigiftListener@onUserBalanceMismatch'
		);

		$events->listen(
			ExpenseApiExceptionEvent::class,
			'QuadStudio\Service\Site\Listeners\DigiftListener@onDigiftApiError'
		);

		$events->listen(
			ExceptionEvent::class,
			'QuadStudio\Service\Site\Listeners\DigiftListener@onException'
		);

	}
}