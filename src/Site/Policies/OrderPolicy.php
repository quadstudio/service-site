<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\User;

class OrderPolicy
{

    public function schedule(User $user, Order $order)
    {
        return $user->admin == 1
            && $order->user->hasGuid()
            && $order->contragent->hasOrganization()
            && $order->can_schedule();
    }

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

    public function distributor(User $user, Order $order)
    {
        return $user->hasPermission('distributors') && $user->distributors()->pluck('id')->contains($order->getAttribute('id'));
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
     * @param  User $user
     * @param  Order $order
     * @return bool
     */
    public function delete(User $user, Order $order)
    {
        return !$order->hasGuid()
            && $order->getAttribute('status_id') == 1
            && (
                $user->getAttribute('id') == $order->getAttribute('user_id')
                || (
                    $user->getAttribute('admin') == 1
                    && $order->address->addressable->id == $user->getAttribute('id')
                )
            );
    }

    /**
     * @param  User $user
     * @param  Order $order
     * @return bool
     */
    public function message(User $user, Order $order)
    {
        return
            $user->getAttribute('id') == $order->getAttribute('user_id')
            || $order->address->addressable->id == $user->getAttribute('id');
    }

}
