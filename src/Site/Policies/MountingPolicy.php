<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\User;

class MountingPolicy
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

    public function pdf(User $user, Mounting $mounting)
    {
        return $mounting->getAttribute('status_id') == 2 && $this->view($user, $mounting);
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Mounting $mounting
     * @return bool
     */
    public function view(User $user, Mounting $mounting)
    {
        return $user->admin == 1 || $user->id == $mounting->getAttribute('user_id');
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Mounting $mounting
     * @return bool
     */
    public function update(User $user, Mounting $mounting)
    {
        return $user->id == $mounting->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Mounting $mounting
     * @return bool
     */
    public function delete(User $user, Mounting $mounting)
    {
        return false;
    }


}
