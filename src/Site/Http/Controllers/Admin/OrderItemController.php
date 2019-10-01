<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\OrderItemRequest;
use QuadStudio\Service\Site\Models\OrderItem;

class OrderItemController extends Controller
{

    use AuthorizesRequests;

    public function update(OrderItemRequest $request, OrderItem $order_item) {
	    $order_item->update($request->input('order_item.'.$order_item->getKey()));
	    return redirect()->route('admin.orders.show', $order_item->order)->with('success', trans('site::order_item.updated'));
    }

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
            $json['redirect'] = route('admin.orders.show', $orderItem->order);
        } else{
            $json['errors'] = trans('site::order_item.error.deleted');
        }

        return response()->json($json, Response::HTTP_OK);

    }

}