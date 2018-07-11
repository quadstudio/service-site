<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\OrderDateFilter;
use QuadStudio\Service\Site\Filters\OrderSearchFilter;
use QuadStudio\Service\Site\Filters\OrderStatusFilter;
use QuadStudio\Service\Site\Filters\OrderSortFilter;
use QuadStudio\Service\Site\Models\Order;
use Illuminate\Support\Facades\Auth;
use Cart;

class OrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Order::class;
    }

    public function create(array $data)
    {
        $order = Auth::user()->orders()->create($data);
        $order->items()->createMany(Cart::toArray());
        Cart::clear();
        return $order;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
            OrderSortFilter::class,
            OrderStatusFilter::class,
            OrderSearchFilter::class,
        ];
    }
}