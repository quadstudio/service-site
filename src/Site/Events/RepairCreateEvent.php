<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Repair;

class RepairCreateEvent
{
    use SerializesModels;

    /**
     * Заказ
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $repair;

    /**
     * Create a new event instance.
     *
     * @param  Repair $repair
     */
    public function __construct($repair)
    {
        $this->repair = $repair;
    }
}
