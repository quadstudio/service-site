<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Engineer;
use QuadStudio\Service\Site\Models\User;

class EngineerPolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Engineer $engineer
     * @return bool
     */
    public function view(User $user, Engineer $engineer)
    {
        return $user->id == $engineer->user_id;
    }

    /**
     * Determine whether the user can create engineers.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the engineer.
     *
     * @param  User $user
     * @param  Engineer $engineer
     * @return bool
     */
    public function update(User $user, Engineer $engineer)
    {
        return $user->id == $engineer->user_id;
    }

    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param  Engineer $engineer
     * @return bool
     */
    public function delete(User $user, Engineer $engineer)
    {
        return ($user->id == $engineer->user_id) && $engineer->canDelete();
    }


}
