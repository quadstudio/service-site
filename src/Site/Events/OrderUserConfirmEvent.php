<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Order;

class OrderUserConfirmEvent
{
    use SerializesModels;

    /**
     * Заявка на авторизацию
     *
     * @var Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param  Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
