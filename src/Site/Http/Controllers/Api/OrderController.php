<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Resources\OrderResource;
use QuadStudio\Service\Site\Models\Order;

class OrderController extends Controller
{

    /**
     * @param Order $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}