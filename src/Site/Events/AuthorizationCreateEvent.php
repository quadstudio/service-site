<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Authorization;

class AuthorizationCreateEvent
{
    use SerializesModels;

    /**
     * Заявка на авторизацию
     *
     * @var Authorization
     */
    public $authorization;

    /**
     * Create a new event instance.
     *
     * @param  Authorization $authorization
     */
    public function __construct(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }
}
