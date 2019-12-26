<?php

namespace QuadStudio\Service\Site\Events\Digift;


use Illuminate\Queue\SerializesModels;

class ExceptionEvent
{

	use SerializesModels;
	/**
	 * @var string
	 */
	public $method;
	/**
	 * @var string
	 */
	public $exception;

	/**
	 * DigiftExceptionEvent constructor.
	 *
	 * @param string $method
	 * @param string $exception
	 */
	public function __construct($method, $exception)
	{

		$this->method = $method;
		$this->exception = $exception;
	}
}