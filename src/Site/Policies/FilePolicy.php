<?php

namespace QuadStudio\Service\Site\Policies;


use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Models\User;

class FilePolicy
{

    public function before(User $user, $ability)
    {
        if ($user->admin == 1) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the file.
     *
     * @param User $user
     * @param File $file
     * @return bool
     */
    public function view(User $user, File $file)
    {
        return $file->user_id == $user->getKey() || $file->fileable->user_id == $user->getKey();
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  User $user
     * @param  File $file
     * @return bool
     */
    public function update(User $user, File $file)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  User $user
     * @param  File $file
     * @return bool
     */
    public function delete(User $user, File $file)
    {
        return true;
    }


}
