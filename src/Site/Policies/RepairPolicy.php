<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Models\User;

class RepairPolicy
{

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Repair $repair
     * @return bool
     */
    public function view(User $user, Repair $repair)
    {
        return $user->id == $repair->user_id;
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
     * @param  Repair $repair
     * @return bool
     */
    public function update(User $user, Repair $repair)
    {
        return $user->id == $repair->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Repair $repair
     * @return bool
     */
    public function delete(User $user, Repair $repair)
    {
        return false;
    }


}
