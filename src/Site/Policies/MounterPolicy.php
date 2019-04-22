<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Mounter;
use QuadStudio\Service\Site\Models\User;

class MounterPolicy
{


    /**
     * @param User $user
     * @param Mounter $mounter
     * @return bool
     */
    public function view(User $user, Mounter $mounter)
    {
        return $user->id == $mounter->userAddress->addressable->id && $mounter->userAddress->addressable_type == 'users';
    }

    /**
     * @param User $user
     * @param Mounter $mounter
     * @return bool
     */
    public function edit(User $user, Mounter $mounter)
    {
        return $user->id == $mounter->userAddress->addressable->id && $mounter->userAddress->addressable_type == 'users';
    }

}
