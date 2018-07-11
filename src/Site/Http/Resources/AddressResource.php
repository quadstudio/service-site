<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        //return array_merge(parent::toArray($request), ['files'  => $this->files]);
//        return [
//            'id'     => $this->id,
//            'number' => $this->number,
//            'status' => new StatusResource($this->whenLoaded('status')),
//            //'employee' => new EmployeeResource($this->whenLoaded('employee')),
//            'files' => ContragentResource::collection($this->whenLoaded('files')),
//            //'files' => ContragentResource::collection($this->files),
//        ];
        return [
            'type' => $this->type->name,
            'country' => $this->country->name,
            'region' => $this->region->name,
            'locality' => $this->locality,
            'name' => $this->name,
        ];
    }
}