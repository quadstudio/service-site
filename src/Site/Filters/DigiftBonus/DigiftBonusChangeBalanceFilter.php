<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DigiftBonusChangeBalanceFilter extends Filter
{

	function apply($builder, RepositoryInterface $repository)
	{
		return $builder
			->where(function ($query) {
				$query
					->orWhereNull('sended_at')
					->orWhere('sended_at', '<=', DB::raw('DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL '.config('site.digift_change_balance_delay', 1).' HOUR)'));
			})
			->whereHas('digiftUser.user', function ($user) {
				$user->where('active', 1);
			})
			->where('digift_bonuses.sended', 0)
			->where('digift_bonuses.blocked', 0)
			->where('created_at', '<=', DB::raw('DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL '.config('site.digift_send_day_delay', 3).' DAY)'));
	}

}