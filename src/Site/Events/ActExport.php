<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Act;

class ActExport
{
    use SerializesModels;

    /**
     * Акт выполненных работ
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $act;

    /**
     * Create a new event instance.
     *
     * @param  Act $act
     */
    public function __construct($act)
    {
        $this->act = $act;
    }
}
