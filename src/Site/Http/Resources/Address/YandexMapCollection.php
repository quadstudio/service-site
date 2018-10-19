<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\ResourceCollection;

class YandexMapCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $name = $request->route()->getName() == 'api.dealers.index' ? trans('site::dealer.text') : trans('site::service.text');
        $found = numberof($this->collection->count(), 'Найден', ['', 'о', 'о']);
        $text = $found . ' ' . $this->collection->count() . ' ' . numberof($this->collection->count(), $name, ['', 'а', 'ов']);
        return [
            'type'     => 'FeatureCollection',
            'found'    => $text,
            'features' => YandexMapResource::collection($this->collection),
        ];
    }
}