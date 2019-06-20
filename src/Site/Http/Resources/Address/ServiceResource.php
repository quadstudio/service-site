<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;
use QuadStudio\Rbac\Models\Role;

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
        //$icon = $request->route()->getName() == 'api.dealers.index' ? 'islands#orangeShoppingIcon' : 'islands#orangeRepairShopIcon';
        $icon = 'islands#orangeRepairShopIcon';

        return [
            'type'       => 'Feature',
            'id'         => $this->id,
            'geometry'   => [
                'type'        => 'Point',
                'coordinates' => [$this->lat(), $this->lon()]
            ],
            'properties' => [
                'balloonContentBody' => view('site::map.balloon.service_center', [
                    'name'      => $this->name,
                    'logo'      => $this->addressable->logo,
                    'web'      => $this->addressable->web,
                    'phones'     => $this->phones,
                    'email'   => $this->email,
                    'is_shop' => $this->is_shop,
                    'is_service' => $this->is_service,
                    'address' => $this->full,
                    'accepts' => $this->addressable->authorization_accepts()->where('role_id', 3)->whereHas('type', function($query){
                        $query->where('brand_id', config('site.brand_default'));
                    })->get()
                ])->render(),
                'balloonMaxWidth'    => 700
            ],
            'options'    => ['preset' => $icon, 'zIndex' => 10],
        ];
    }
}
