<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
                'coordinates' => array_reverse(explode(',', $this->address()->geo))
            ],
            'properties' => [
                'balloonContentBody' => view('site::service.balloon', [
                    'sc'      => $this->sc()->name ? $this->sc()->name : $this->name,
                    'asc'      => $this->hasRole('asc'),
                    'dealer'      => $this->hasRole('dealer'),
                    'web'      => $this->sc()->web ? $this->sc()->web : $this->web,
                    'phones'     => $this->sc()->phones()->exists() ? $this->sc()->phones : $this->phones,
                    'email'   => $this->email,
                    'address' => $this->address(),
                    //'phones'  => $this->sc_phones()
                ])->render(),
                'balloonMaxWidth'    => 700
            ],
            'options'    => ['preset' => 'islands#orangeStarIcon', 'zIndex' => 10],
        ];
    }
}