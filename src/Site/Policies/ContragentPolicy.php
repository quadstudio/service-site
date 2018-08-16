<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\User;

class ContragentPolicy
{

    public function index(User $user)
    {
        return $user->hasPermission('contragents');
    }

    /**
     * Determine whether the user can view the contragent.
     *
     * @param User $user
     * @param Contragent $contragent
     * @return bool
     */
    public function view(User $user, Contragent $contragent)
    {
        return $user->hasPermission('contragents') && ($user->id == $contragent->user_id);
    }

    /**
     * Determine whether the user can create contragents.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('contragents') && ($user->id > 0);
    }

    /**
     * Determine whether the user can update the contragent.
     *
     * @param  User $user
     * @param  Contragent $contragent
     * @return bool
     */
    public function edit(User $user, Contragent $contragent)
    {
        return $user->hasPermission('contragents') && ($user->id == $contragent->user_id);
    }

    /**
     * Determine whether the user can delete the contragent.
     *
     * @param  User $user
     * @param  Contragent $contragent
     * @return bool
     */
    public function delete(User $user, Contragent $contragent)
    {
        return $user->hasPermission('contragents') && ($user->id == $contragent->user_id) && $contragent->orders()->count() == 0;
    }


}
