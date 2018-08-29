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
            'id'     => $this->id,
            'guid'     => $this->guid,
            'cost' => $this->totalCost,
            'created_at' => \Carbon\Carbon::instance($this->created_at)->format('Y-m-d H:i:s' ),
            //'status' => new StatusResource($this->whenLoaded('status')),
            //'employee' => new EmployeeResource($this->whenLoaded('employee')),
            //'files' => FileResource::collection($this->whenLoaded('files')),
            //'files' => FileResource::collection($this->files),
        ];
    }
}