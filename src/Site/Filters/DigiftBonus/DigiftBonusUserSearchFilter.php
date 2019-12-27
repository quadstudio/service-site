<?php

namespace QuadStudio\Service\Site\Filters\DigiftBonus;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class DigiftBonusUserSearchFilter extends BaseFilter
{

	use BootstrapInput;

	protected $render = true;
	protected $search = 'search';

	protected function columns()
	{
		return [
			'users.name',
		];
	}

	public function label()
	{
		return trans('site::digift_bonus.placeholder.search');
	}

}