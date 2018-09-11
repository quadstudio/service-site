<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Difficulty;

class DifficultyPolicy
{


    /**
     * @param  User $user
     * @param  Difficulty $difficulty
     * @return bool
     */
    public function delete(User $user, Difficulty $difficulty)
    {
        return $user->admin == 1 && $difficulty->repairs()->count() == 0;
    }


}
