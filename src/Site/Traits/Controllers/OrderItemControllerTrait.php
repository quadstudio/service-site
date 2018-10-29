<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Models\OrderItem;

trait OrderItemControllerTrait
{

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
            $json['redirect'] = route('orders.show', $item->order);
        } else{
            $json['errors'] = 'Ошибка удаления';
        }

        return response()->json($json);

    }

}