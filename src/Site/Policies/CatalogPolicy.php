<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Catalog;

class CatalogPolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Catalog $catalog
     * @return bool
     */
    public function view(User $user, Catalog $catalog)
    {
        return true;
    }

    /**
     * Determine whether the user can list equipments
     *
     * @param  User $user
     * @return bool
     */
    public function list(User $user)
    {
        return $user->hasPermission('equipment.list');
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
     * @param  Catalog $catalog
     * @return bool
     */
    public function update(User $user, Catalog $catalog)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param  Catalog $catalog
     * @return bool
     */
    public function delete(User $user, Catalog $catalog)
    {
        return $user->admin == 1 && $catalog->canDelete();
    }


}
