<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\User;

class StorehousePolicy
{

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
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Storehouse $storehouse
     * @return bool
     */
    public function view(User $user, Storehouse $storehouse)
    {
        return $user->getKey() == $storehouse->getAttribute('user_id');
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Storehouse $storehouse
     * @return bool
     */
    public function edit(User $user, Storehouse $storehouse)
    {
        return $user->id == $storehouse->getAttribute('user_id');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Storehouse $storehouse
     * @return bool
     */
    public function delete(User $user, Storehouse $storehouse)
    {
        return $user->id == $storehouse->getAttribute('user_id');
    }


}
