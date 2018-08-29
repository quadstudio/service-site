<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepairResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id'     => 'Работы по гарантийному обслуживанию оборудования № '.$this->id.' '.\Carbon\Carbon::instance($this->created_at)->format('d.m.Y' ),
            'count' => 1,
            'cost' => $this->totalCost,
            //'nds_act' => $this->contragent,
            //'status' => new StatusResource($this->whenLoaded('status')),
            //'employee' => new EmployeeResource($this->whenLoaded('employee')),
            //'files' => FileResource::collection($this->whenLoaded('files')),
            //'files' => FileResource::collection($this->files),
        ];
    }
}