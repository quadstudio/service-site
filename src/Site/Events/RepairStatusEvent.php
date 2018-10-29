<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Repair;

class RepairStatusEvent
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
     * @param null $adminMessage
     */
    public function __construct($repair, $adminMessage = null)
    {
        $this->repair = $repair;
        $this->adminMessage = $adminMessage;
    }
}
