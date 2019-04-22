<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //$name = $request->route()->getName() == 'api.dealers.index' ? trans('site::dealer.text') : trans('site::service.text');
        $name = trans('site::map.service_center.text');
        $found = numberof($this->collection->count(), 'Найден', ['', 'о', 'о']);
        $text = $found . ' ' . $this->collection->count() . ' ' . numberof($this->collection->count(), $name, ['', 'а', 'ов']);
        return [
            'type'     => 'FeatureCollection',
            'found'    => $text,
            'features' => ServiceResource::collection($this->collection),
        ];
    }
}