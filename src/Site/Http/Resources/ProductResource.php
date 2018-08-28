<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use QuadStudio\Service\Site\Facades\Site;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'sku'  => $this->sku,
            'name' => $this->name,
            'type' => $this->type->name,
            'unit' => $this->unit,
            'price' => $this->price()->price(),
            'format' => Site::format($this->price()->price()),
            'image' => $this->image()->src(),
        ];
    }
}