<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class StorehouseUserExcelFilter extends Filter
{

	function apply($builder, RepositoryInterface $repository)
	{
		return $builder
			->where('storehouses.enabled', 1)
			->wherehas('user', function ($user) {
				$user
					->where('users.admin', 1)
					->orWhere(function ($query) {
						$query
							->when(auth()->user()->only_ferroli == 0, function ($query) {
								$query
									->where('users.active', 1)
									->where('users.display', 1);
							});
					});

			})
			->whereHas('addresses', function ($address) {

				$address->when(auth()->user()->only_ferroli == 0,
					function ($query) {
						$query->whereHas('regions', function ($region) {
							$region->where('regions.id', auth()->user()->region_id);
						});
					});
			});
	}
}