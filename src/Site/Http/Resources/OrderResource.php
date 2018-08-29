<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('items');

        return [
            'id'         => $this->id,
            'guid'       => $this->guid,
            'user'       => [
                'guid'         => $this->user->guid,
                'currency_id'  => $this->user->currency_id,
                'warehouse_id' => $this->user->warehouse_id,
            ],
            'items'      => OrderItemResource::collection($this->items),
            'contragent' => new ContragentResource($this->contragent),
        ];

    }
}