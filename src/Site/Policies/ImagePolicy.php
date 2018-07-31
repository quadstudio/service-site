<?php

namespace QuadStudio\Service\Site\Policies;


use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\User;

class ImagePolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Image $image
     * @return bool
     */
    public function view(User $user, Image $image)
    {
        return true;
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
     * @param   Image $image
     * @return bool
     */
    public function update(User $user, Image $image)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param   Image $image
     * @return bool
     */
    public function delete(User $user, Image $image)
    {
        return true;
    }


}
