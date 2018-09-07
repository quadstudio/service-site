<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Datasheet;

class DatasheetPolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Datasheet $datasheet
     * @return bool
     */
    public function view(User $user, Datasheet $datasheet)
    {
        return $datasheet->active == 1;
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
     * @param  Datasheet $datasheet
     * @return bool
     */
    public function edit(User $user, Datasheet $datasheet)
    {
        return $user->admin == 1;
    }

    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param  Datasheet $datasheet
     * @return bool
     */
    public function delete(User $user, Datasheet $datasheet)
    {
        return $user->admin == 1;
    }


}
