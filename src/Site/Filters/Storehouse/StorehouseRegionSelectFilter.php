<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;

class StorehouseRegionSelectFilter extends WhereFilter
{

	use BootstrapSelect;

	protected $render = true;

	function apply($builder, RepositoryInterface $repository)
	{
		if ($this->canTrack() && !is_null($key = $this->get($this->name()))) {
			$builder = $builder->whereHas('addresses', function ($query) use ($key) {
				$query->where(DB::raw($this->column()), $this->operator(), $key);
			});
		}

		return $builder;
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return 'region';
	}

	/**
	 * @return string
	 */
	public function column(): string
	{

		return 'region_id';

	}

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return array
	 */
	public function options(): array
	{

		$region = Region::query()
			->whereHas('addresses', function ($query) {
				$query->whereTypeId(6)->has('storehouse');
			})
			->when(!auth()->user()->admin, function ($query) {
				$query->whereHas('addresses', function ($query) {
					$query
						->where('addressable_type', 'users')
						->where('addressable_id', auth()->user()->getAuthIdentifier());
				});
			});
		//dump($region->getBindings());
		//dd($region->toSql());

		return $region->pluck('name', 'id')
			->prepend(trans('site::address.help.region_defaults'), '')
			->toArray();
	}

	public function defaults(): array
	{
		return [''];
	}

	public function label()
	{
		return trans('site::address.region_id');
	}
}