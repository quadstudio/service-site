<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContragentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('addresses');
        return [
            'id' => $this->id,
            'guid' => $this->guid,
            'type' => $this->type->name,
            'name' => $this->name,
            'inn'  => $this->inn,
            'ogrn' => $this->ogrn,
            'okpo' => $this->okpo,
            'kpp'  => $this->kpp,
            'rs'   => $this->rs,
            'ks'   => $this->ks,
            'bik'  => $this->bik,
            'bank' => $this->bank,
            'nds' => $this->nds,
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}