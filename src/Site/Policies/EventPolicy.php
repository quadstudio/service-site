<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\User;

class EventPolicy
{

    /**
     * Determine whether the user can delete the event.
     *
     * @param  User $user
     * @param  Event $event
     * @return bool
     */
    public function delete(User $user, Event $event)
    {
        return $user->getAttribute('admin') == 1 && in_array($event->getAttribute('status_id'), [1, 4, 5]) && $event->members()->count() == 0;
    }


}
