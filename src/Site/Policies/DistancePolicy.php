<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Distance;

class DistancePolicy
{


    /**
     * Determine whether the user can delete the engineer.
     *
     * @param  User $user
     * @param  Distance $distance
     * @return bool
     */
    public function delete(User $user, Distance $distance)
    {
        return $user->admin == 1 && $distance->repairs()->count() == 0;
    }


}
