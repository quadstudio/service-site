<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DigiftBonusCheckBalanceFilter extends Filter
{

	function apply($builder, RepositoryInterface $repository)
	{
		return $builder
			->whereHas('digiftUser.user', function ($user) {
				$user->where('active', 1);
			})
			->where('digift_bonuses.sended', 1)
			->where('digift_bonuses.blocked', 0);
	}

}