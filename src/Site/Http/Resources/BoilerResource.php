<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoilerResource extends JsonResource
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
            'id'        => $this->id,
            'sku'       => $this->sku,
            'name'      => $this->name,
            'type'      => $this->type->name,
            'equipment' => new EquipmentResource($this->equipment),
        ];
    }
}