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

        return [
            'type'     => 'FeatureCollection',
            'features' => YandexMapResource::collection($this->collection),
        ];
    }
}