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
        $this->load('addresses')->load('contacts')->load('contragents');

        return [
            'id'            => $this->id,
            'guid'          => $this->guid,
            'name'          => $this->name,
            'email'         => $this->email,
            'address'       => new AddressResource($this->address()),
            'contacts'      => ContactResource::collection($this->whenLoaded('contacts')),
            'contragents'      => ContragentResource::collection($this->whenLoaded('contragents')),
        ];

    }
}