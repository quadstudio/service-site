<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\OrderItem;

class OrderItemController extends Controller
{

    use AuthorizesRequests;

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderItem $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $item)
    {

        $this->authorize('delete', $item);
        if ($item->delete()) {
            $json['redirect'] = route('admin.orders.show', $item->order);
        } else{
            $json['errors'] = 'Ошибка удаления';
        }

        return response()->json($json);

    }

}