<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;
use QuadStudio\Rbac\Models\Role;

class MounterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $icon = 'islands#circleDotIcon';
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
                'balloonContentBody' => view('site::map.balloon.mounter_request', [
                    'id'      => $this->id,
                    'name'      => $this->name,
                    'roles'      => $roles,
                    'logo'      => $this->addressable->logo,
                    'web'      => $this->addressable->web,
                    'phones'     => $this->phones,
                    'email'   => $this->email,
                    'address' => $this->full,
                    'accepts' => $this->addressable->authorization_accepts()->where('role_id', 11)->whereHas('type', function($query){
                        $query->where('brand_id', 1);
                    })->get()
                ])->render(),
                'balloonMaxWidth'    => 700
            ],
            'options'    => ['preset' => $icon, 'zIndex' => 10],
        ];
    }
}
