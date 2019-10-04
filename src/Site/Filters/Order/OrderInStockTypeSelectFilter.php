<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\OrderStatus;

class OrderInStockTypeSelectFilter extends WhereFilter
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
		return collect(trans('site::order.help.in_stock_type', []))
			->prepend(trans('site::messages.select_no_matter'), '')
			->toArray();
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return 'in_stock_type';
	}

	/**
	 * @return string
	 */
	public function column(): string
	{

		return 'orders.in_stock_type';

	}

	public function defaults(): array
	{
		return [''];
	}

	public function label()
	{
		return trans('site::order.in_stock_type');
	}
}