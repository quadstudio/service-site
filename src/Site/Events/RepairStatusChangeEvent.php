<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Repair;

class RepairStatusChangeEvent
{
    use SerializesModels;

    /**
     * Заказ
     *
     * @var Repair
     */
    public $repair;
    /**
     * @var string
     */
    public $adminMessage;

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
