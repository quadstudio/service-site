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
//        $d = $this->sc_phones();
//        dd($d);
//        dump($d->toSql());
//        dd($d->getBindings());
//        return parent::toArray($request);
//        //return array_merge(parent::toArray($request), ['files'  => $this->files]);
//        $this->load('contragents')->load('addresses')->load('contacts');
        return [
            'type'       => 'Feature',
            'id'         => $this->id,
            'geometry'   => [
                'type'        => 'Point',
                'coordinates' => array_reverse(explode(',', $this->address()->geo))
            ],
            'properties' => [
                'balloonContentBody' => view('site::service.balloon', [
                    'sc'      => $this->sc(),
                    //'web'     => $this->web,
                    'email'   => $this->email,
                    'address' => $this->address(),
                    //'phones'  => $this->sc_phones()
                ])->render(),
                'balloonMaxWidth'    => 700
            ],
            'options'    => ['preset' => 'islands#orangeStarIcon', 'zIndex' => 10],
            //'contragents' => ContragentResource::collection($this->whenLoaded('contragents')),
            //'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            //'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
        ];
    }
}