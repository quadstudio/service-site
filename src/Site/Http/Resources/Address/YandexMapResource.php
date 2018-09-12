<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class YandexMapResource extends JsonResource
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
            'type'       => 'Feature',
            'id'         => $this->id,
            'geometry'   => [
                'type'        => 'Point',
                'coordinates' => [$this->lat(), $this->lon()]
            ],
            'properties' => [
                'balloonContentBody' => view('site::service.balloon', [
                    'name'      => $this->name,
                    'asc'      => $this->addressable->hasRole('asc'),
                    'dealer'      =>  $this->addressable->hasRole('dealer'),
                    'web'      => $this->addressable->web,
                    'phones'     => $this->phones,
                    'email'   => $this->addressable->email,
                    'address' => $this->full,
                    //'phones'  => $this->sc_phones()
                ])->render(),
                'balloonMaxWidth'    => 700
            ],
            'options'    => ['preset' => 'islands#orangeStarIcon', 'zIndex' => 10],
        ];
    }
}