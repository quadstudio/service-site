<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\OrderItem;

class OrderItemController extends Controller
{

    use AuthorizesRequests;

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  OrderItem $orderItem
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Exception
	 */
	public function destroy(OrderItem $orderItem)
	{
		$this->authorize('delete', $orderItem);
		if ($orderItem->delete()) {
			$json['redirect'] = route('orders.show', $orderItem->order);
		} else{
			$json['errors'] = trans('site::order_item.error.deleted');
		}

		return response()->json($json, Response::HTTP_OK);

	}

}