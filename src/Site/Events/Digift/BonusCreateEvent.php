<?php

namespace QuadStudio\Service\Site\Events\Digift;


use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Mounting;

class BonusCreateEvent
{

	use SerializesModels;
	/**
	 * @var Mounting
	 */
	public $mounting;


	/**
	 * DigiftBonusCreateEvent constructor.
	 *
	 * @param Mounting $mounting
	 */
	public function __construct(Mounting $mounting)
	{

		$this->mounting = $mounting;
	}
}