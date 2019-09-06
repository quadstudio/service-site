<?php

namespace QuadStudio\Service\Site\Filters\Act;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Contragent;

class ActContragentFilter extends WhereFilter
{

	use BootstrapSelect;

	protected $render = true;

	function apply($builder, RepositoryInterface $repository)
	{
		if ($this->canTrack() && !is_null($contragent_id = $this->get($this->name()))) {
			$builder = $builder->where(DB::raw($this->column()), $this->operator(), $contragent_id);
		}

		return $builder;
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return 'contragent';
	}

	/**
	 * @return string
	 */
	public function column(): string
	{

		return 'acts.contragent_id';

	}

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return array
	 */
	public function options(): array
	{
		return Contragent::query()
			->where(function ($query) {
				if (auth()->user()->admin == 1) {
					$query->has('acts');
				} else {
					$query->whereHas('acts', function ($query) {
						$query->where('user_id', auth()->user()->getAuthIdentifier());
					});
				}

			})->orderBy('name')
			->pluck('name', 'id')
//            ->map(function ($item, $key) {
//                return str_limit($item, config('site.name_limit', 25));
//            })
			->prepend(trans('site::messages.select_no_matter'), '')
			->toArray();
	}

	public function defaults(): array
	{
		return [''];
	}

	public function label()
	{
		return trans('site::act.contragent_id');
	}
}