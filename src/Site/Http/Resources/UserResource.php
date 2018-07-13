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
        //return parent::toArray($request);
        //return array_merge(parent::toArray($request), ['files'  => $this->files]);
        $this->load('contragents')->load('addresses')->load('contacts');
        return [
            'id'     => $this->id,
            'guid' => $this->guid,
            'name' => $this->name,
            'type' => $this->type->name,
            'email' => $this->email,
            'address' => new AddressResource($this->address()),
            'contragents' => ContragentResource::collection($this->whenLoaded('contragents')),
            //'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
            //'files' => ContragentResource::collection($this->files),
        ];
//        return [
//            'id' => $this->id,
//            'number' => $this->number,
//            'files' => $this->files,
//        ];
    }
}