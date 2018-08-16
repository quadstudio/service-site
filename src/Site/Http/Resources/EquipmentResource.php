<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use QuadStudio\Service\Site\Facades\Site;

class EquipmentResource extends JsonResource
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
            'name'      => $this->name,
            'route' => route('equipments.show', $this),
            'image'     => $this->image()->src(),
            'cost_work' => $this->cost_work,
            'cost_road' => $this->cost_road,
            'format' => [
                'cost_work' => Site::format($this->cost_work),
                'cost_road' => Site::format($this->cost_road),
            ],
            'catalog'   => !is_null($this->catalog_id) ? new CatalogResource($this->catalog) : null,
        ];
    }
}