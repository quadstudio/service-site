<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Order\OrderStatusFilter;
use QuadStudio\Service\Site\Filters\OrderSearchFilter;

use QuadStudio\Service\Site\Filters\OrderSortFilter;
use QuadStudio\Service\Site\Models\Order;

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