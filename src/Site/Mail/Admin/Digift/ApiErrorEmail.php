<?php

namespace QuadStudio\Service\Site\Mail\Admin\Digift;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApiErrorEmail extends Mailable implements ShouldQueue
{

	use Queueable, SerializesModels;
	/**
	 * @var array
	 */
	public $request_data;
	/**
	 * @var array
	 */
	public $exception;


	/**
	 * Create a new event instance.
	 *
	 * @param array $request_data
	 * @param array $exception
	 */
	public function __construct(array $request_data, array $exception)
	{
		$this->request_data = $request_data;
		$this->exception = $exception;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this
			->subject(trans('site::digift_expense.email.api.title'))
			->view('site::email.admin.digift_expense.api');
	}
}
