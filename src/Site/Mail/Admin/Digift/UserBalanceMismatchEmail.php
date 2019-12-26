<?php

namespace QuadStudio\Service\Site\Mail\Admin\Digift;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\DigiftUser;

class UserBalanceMismatchEmail extends Mailable implements ShouldQueue
{

	use Queueable, SerializesModels;
	/**
	 * @var DigiftUser
	 */
	public $digiftUser;
	/**
	 * @var array
	 */
	public $balance;

	/**
	 * Create a new message instance.
	 *
	 * @param DigiftUser $digiftUser
	 * @param array $balance
	 */
	public function __construct(DigiftUser $digiftUser, array $balance)
	{

		$this->digiftUser = $digiftUser;
		$this->balance = $balance;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this
			->subject(trans('site::digift_user.mail.balance_mismatch.title'))
			->view('site::email.admin.digift_user.balance_mismatch');
	}
}
