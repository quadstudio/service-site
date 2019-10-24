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

	public function update(OrderItemRequest $request, OrderItem $order_item)
	{
		$order_item->fill($request->input('order_item.' . $order_item->getKey()));

		if ($order_item->isDirty()) {

			$order_item->syncChanges();
			$changes = [trans('site::order_item.message.product', ['product' => $order_item->product->name()])];

			foreach ($order_item->getChanges() as $key => $value) {
				$changes[] = trans('site::order_item.message.item', [
					'column' => trans('site::order_item.' . $key) . trans('site::order_item.message.columns.' . $key),
					'original' => $order_item->getOriginal($key),
					'change' => $value,
				]);
			}

			$text = implode("\r\n", $changes);
			$receiver_id = $request->user()->getKey();

			if ($order_item->save()) {
				$order_item->order->messages()->save($request->user()->outbox()->create(compact('text', 'receiver_id')));
			}

		}

		return redirect()->route('admin.orders.show', $order_item->order)->with('success', trans('site::order_item.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param OrderItemRequest $request
	 * @param  OrderItem $orderItem
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Exception
	 */
	public function destroy(OrderItemRequest $request, OrderItem $orderItem)
	{
		$this->authorize('delete', $orderItem);
		if ($orderItem->delete()) {

			$changes = [
				trans('site::order_item.message.delete', ['product' => $orderItem->product->name()]),
			];
			foreach (['price', 'quantity', 'weeks_delivery'] as $key) {
				$changes[] = trans('site::order_item.' . $key) . trans('site::order_item.message.columns.' . $key) . $orderItem->getOriginal($key);
			}

			$text = implode("\r\n", $changes);

			$receiver_id = $request->user()->getKey();
			$orderItem->order->messages()->save($request->user()->outbox()->create(compact('text', 'receiver_id')));

			$json['redirect'] = route('admin.orders.show', $orderItem->order);
		} else {
			$json['errors'] = trans('site::order_item.error.deleted');
		}

		return response()->json($json, Response::HTTP_OK);

	}

}