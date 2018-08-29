<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Models\User;

class ActPolicy
{

    public function schedule(User $user, Act $act)
    {
        return $user->admin == 1
            && $act->user->hasGuid()
            && $act->can_schedule();
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Act $act
     * @return bool
     */
    public function view(User $user, Act $act)
    {
        return $user->id == $act->user_id;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Act $act
     * @return bool
     */
    public function update(User $user, Act $act)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Act $act
     * @return bool
     */
    public function delete(User $user, Act $act)
    {
        return false;
    }


}
