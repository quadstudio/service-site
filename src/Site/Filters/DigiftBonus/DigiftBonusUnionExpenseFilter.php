<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DigiftBonusUnionExpenseFilter extends Filter
{

	/**
	 * @param $builder
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	function apply($builder, RepositoryInterface $repository)
	{

		$expenses = DB::table('digift_expenses')
			->select(
				'digift_expenses.created_at',
				'digift_expenses.operationValue',
				'digift_expenses.user_id',
				DB::raw('0 AS blocked'),
				DB::raw('NULL AS bonusable_type'),
				DB::raw('NULL AS bonusable_id'),
				DB::raw('"decrease" AS operationType')
			);

		$bonuses = DB::table('digift_bonuses')
			->select(
				'digift_bonuses.created_at',
				'digift_bonuses.operationValue',
				'digift_bonuses.user_id',
				'digift_bonuses.blocked',
				'digift_bonuses.bonusable_type',
				'digift_bonuses.bonusable_id',
				DB::raw('"increase" AS operationType')
			)
			->unionAll($expenses);
		$builder = DB::table('digift_users')
			->joinSub($bonuses, 'bonuses', function ($join) {
				$join->on('digift_users.id', '=', 'bonuses.user_id');
			})
			->join('users', 'users.id', '=', 'digift_users.user_id')
			->select(
				DB::raw('users.id as user_id'),
				DB::raw('users.name as user_name'),
				DB::raw('DATE(bonuses.created_at) as created_at'),
				'bonuses.blocked',
				'bonuses.operationValue',
				'bonuses.operationType',
				'bonuses.bonusable_type',
				'bonuses.bonusable_id'
			)
			->orderByDesc('bonuses.created_at');

		return $builder;

	}

}