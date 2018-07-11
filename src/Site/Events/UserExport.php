<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;

class UserExport
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
