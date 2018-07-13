<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SerialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //dd($this->product->equipment);
        return [
            'serial' => $this->id,
            'product' => $this->product->name,
            'sku' => $this->product->sku,
            'model' => $this->product->equipment->name,
            'catalog' => $this->product->equipment->catalog->parentTreeName(),
            'cost_work' => $this->product->equipment->cost_work,
            'cost_road' => $this->product->equipment->cost_road,
            'currency' => $this->product->equipment->currency->title,
        ];
    }
}