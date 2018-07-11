<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Launch;

class LaunchPolicy
{

    /**
     * Determine whether the user can view the launch.
     *
     * @param User $user
     * @param Launch $launch
     * @return bool
     */
    public function view(User $user, Launch $launch)
    {
        return $user->id == $launch->user_id;
    }

    /**
     * Determine whether the user can create launches.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the launch.
     *
     * @param  User $user
     * @param  Launch $launch
     * @return bool
     */
    public function update(User $user, Launch $launch)
    {
        return $user->id == $launch->user_id;
    }

    /**
     * Determine whether the user can delete the launch.
     *
     * @param  User $user
     * @param  Launch $launch
     * @return bool
     */
    public function delete(User $user, Launch $launch)
    {
        return $user->id == $launch->user_id && $launch->canDelete();
    }


}
