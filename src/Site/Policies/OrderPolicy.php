<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Models\Order;

class OrderPolicy
{

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Order $order
     * @return bool
     */
    public function update(User $user, Order $order)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Order $order
     * @return bool
     */
    public function delete(User $user, Order $order)
    {
        return false;
    }


}