<?php

namespace QuadStudio\Service\Site\Filters\Act;

use Illuminate\Support\Collection;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class ActDateCreatedFromFilter extends DateFilter
{

	use BootstrapTempusDominusDate;

	protected $render = true;
	protected $search = 'date_created_from';

	public function label()
	{
		return trans('site::act.created_at');
	}

	/**
	 * @return string
	 */
	public function column()
	{
		return 'acts.created_at';
	}

	/**
	 * @return string
	 */
	protected function placeholder()
	{
		return trans('site::messages.date_from');
	}

	/**
	 * @return Collection
	 */
	protected function attributes()
	{
		return parent::attributes()->merge(['style' => 'width:100px;']);
	}

	/**
	 * @return string
	 */
	protected function operator()
	{
		return '>=';
	}


}