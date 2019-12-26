<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\DigiftBonus;

class DigiftBonusRepository extends Repository
{

	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public function model()
	{
		return DigiftBonus::class;
	}

	/**
	 * @return array
	 */
	public function track(): array
	{
		return [

		];
	}
}