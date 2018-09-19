<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('repairs');
        $detail = $this->details()->where('our', 0)->first();

        return [
            'id'              => $this->id,
            'guid'            => $this->guid,
            'nds'             => $detail->nds_act == 0 ? 'БезНДС' : 'НДС' . $detail->nds_value,
            'user'            => [
                'guid'         => $this->user->guid,
                'currency_id'  => $this->user->currency_id,
                'warehouse_id' => $this->user->warehouse_id,
            ],
            'contragent' => new ContragentResource($this->contragent),
            'repairs'         => RepairResource::collection($this->repairs),
        ];

    }
}