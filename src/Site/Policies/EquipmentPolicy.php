<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Equipment;

class EquipmentPolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Equipment $equipment
     * @return bool
     */
    public function view(User $user, Equipment $equipment)
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
        return $user->admin == 1;
    }

    /**
     * Determine whether the user can update the engineer.
     *
     * @param  User $user
     * @param  Equipment $equipment
     * @return bool
     */
    public function update(User $user, Equipment $equipment)
    {
        return $user->admin == 1;
    }

    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param  Equipment $equipment
     * @return bool
     */
    public function delete(User $user, Equipment $equipment)
    {
        return $user->admin == 1 && $equipment->canDelete();
    }


}
