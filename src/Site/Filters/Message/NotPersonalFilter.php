<?php

namespace QuadStudio\Service\Site\Filters\Message;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class NotPersonalFilter extends Filter
{

	function apply($builder, RepositoryInterface $repository)
	{
		return $builder->where('personal', 0);
	}
}