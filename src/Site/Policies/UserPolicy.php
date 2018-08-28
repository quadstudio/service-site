<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;

class UserPolicy
{

    public function schedule(User $user, User $export_user)
    {
        return $user->admin == 1 && $export_user->can_schedule();
    }

    public function buy(User $user)
    {
        return $user->hasPermission('buy');
    }

    public function product_list(User $user)
    {
        return $user->hasPermission('product.list');
    }

    public function equipment_list(User $user)
    {
        return $user->hasPermission('equipment.list');
    }

}
