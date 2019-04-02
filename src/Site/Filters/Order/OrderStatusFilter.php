<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\OrderStatus;

class OrderStatusFilter extends WhereFilter
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
        return ['' => trans('site::messages.select_no_matter')] + OrderStatus::query()->whereHas('orders', function ($query) {
                if (auth()->user()->admin == 0) {
                    $query->where('user_id', auth()->user()->getAuthIdentifier());
                }
            })->orderBy('id')->pluck('name', 'id')->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'status_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'orders.status_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::order.status_id');
    }
}