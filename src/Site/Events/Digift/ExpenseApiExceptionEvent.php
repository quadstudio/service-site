<?php

namespace QuadStudio\Service\Site\Events\Digift;


use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\DigiftUser;

class ExpenseApiExceptionEvent
{

	use SerializesModels;
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
}