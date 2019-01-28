<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Member;

class MemberCreateEvent
{
    use SerializesModels;

    /**
     * Заявка
     *
     * @var Member
     */
    public $member;

    /**
     * Create a new event instance.
     *
     * @param  Member $member
     */
    public function __construct($member)
    {
        $this->member = $member;
    }
}
