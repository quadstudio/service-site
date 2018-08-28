<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('addresses')->load('contacts');

        return [
            'id'            => $this->id,
            'guid'          => $this->guid,
            'name'          => $this->name,
//            'type'          => $this->type->name,
            'email'         => $this->email,
//            'currency_id'   => $this->currency_id,
//            'warehouse_id'  => $this->warehouse_id,
//            'price_type_id' => $this->price_type_id,
            'address'       => new AddressResource($this->address()),
            'contacts'      => ContactResource::collection($this->whenLoaded('contacts')),

        ];

    }
}