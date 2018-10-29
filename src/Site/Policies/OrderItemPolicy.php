<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\OrderItem;
use QuadStudio\Service\Site\Models\User;

class OrderItemPolicy
{

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  OrderItem $item
     * @return bool
     */
    public function delete(User $user, OrderItem $item)
    {
        return !$item->order->hasGuid();
    }


}
