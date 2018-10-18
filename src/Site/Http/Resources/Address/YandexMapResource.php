<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;
use QuadStudio\Rbac\Models\Role;

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
        $roles = [];
        foreach (Role::query()->where('display', 1)->get() as $role){
            if($this->addressable->hasRole($role->name)){
                $roles[] = $role->title;
            }
        }
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
                    'roles'      => $roles,
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