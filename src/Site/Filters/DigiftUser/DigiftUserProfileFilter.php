<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DigiftUserProfileFilter extends Filter
{

	function apply($builder, RepositoryInterface $repository)
	{
		return $builder
			->where(function ($query) {
				$query
					->orWhereNull('checked_at')
					->orWhere('checked_at', '<=', DB::raw('DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL '.config('site.digift_check_balance_delay', 24).' HOUR)'));
			})
			->whereHas('user', function ($user) {
				$user->where('active', 1);
			})
			->whereHas('digiftBonuses', function ($digiftBonus) {
				$digiftBonus
					->where('digift_bonuses.sended', 1)
					->where('digift_bonuses.blocked', 0);
			});

	}

}