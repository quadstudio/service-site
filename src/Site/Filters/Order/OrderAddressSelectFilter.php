<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Address;

class OrderAddressSelectFilter extends WhereFilter
{

	use BootstrapSelect;

	protected $render = true;

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return array
	 */
	public function options(): array
	{
		return Address::query()->whereHas('orders', function ($query) {
			if (auth()->user()->admin == 0) {
				$query->where('user_id', auth()->user()->getAuthIdentifier());
			}
		})
			->orderBy('id')->pluck('name', 'id')
			->prepend(trans('site::messages.select_no_matter'), '')->toArray();
		/**
		 * ->map(function ($item, $key) {
		 * return str_limit($item, 50);
		 * })
		 */
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return 'address_id';
	}

	/**
	 * @return string
	 */
	public function column(): string
	{

		return 'orders.address_id';

	}

	public function defaults(): array
	{
		return [''];
	}

	public function label()
	{
		return trans('site::order.address_id');
	}
}