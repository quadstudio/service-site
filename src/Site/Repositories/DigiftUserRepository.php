<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\DigiftUser;

class DigiftUserRepository extends Repository
{

	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public function model()
	{
		return DigiftUser::class;
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