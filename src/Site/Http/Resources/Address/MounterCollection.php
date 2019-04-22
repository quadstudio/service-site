<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MounterCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $name = trans('site::map.mounter_request.text');
        $found = numberof($this->collection->count(), 'Найден', ['', 'о', 'о']);
        $text = $found . ' ' . $this->collection->count() . ' ' . numberof($this->collection->count(), $name, ['', 'а', 'ов']);
        return [
            'type'     => 'FeatureCollection',
            'found'    => $text,
            'features' => MounterResource::collection($this->collection),
        ];
    }
}