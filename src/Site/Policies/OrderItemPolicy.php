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
	 * @param  OrderItem $orderItem
	 *
	 * @return bool
	 */
	public function delete(User $user, OrderItem $orderItem)
	{
		return !$orderItem->order->hasGuid()
			&& (
				$orderItem->order->status_id == 1 || $orderItem->order->status_id == 7 && $user->admin == 0
			);
	}

	public function edit(User $user, OrderItem $orderItem)
	{
		return  $user->admin == 1 && $orderItem->order->in_stock_type == 2 && in_array($orderItem->order->status_id, array(1,7));
	}


}
