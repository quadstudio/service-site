<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Order;

class OrderScheduleEvent
{
    use SerializesModels;

    /**
     * Заказ
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param  Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
