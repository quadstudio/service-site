<?php

namespace QuadStudio\Service\Site\Mail\Admin\Digift;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\DigiftUser;

class ExceptionEmail extends Mailable implements ShouldQueue
{

	use Queueable, SerializesModels;
	/**
	 * @var string
	 */
	public $method;
	/**
	 * @var string
	 */
	public $exception;


	/**
	 * DigiftExceptionEmail constructor.
	 *
	 * @param string $method
	 * @param string $exception
	 */
	public function __construct($method, $exception)
	{

		$this->method = $method;
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
			->subject(trans('site::digift.email.exception.title'))
			->view('site::email.admin.digift.exception');
	}
}
