<?php

namespace QuadStudio\Service\Site\Http\Resources\Address;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DealerCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $name = trans('site::dealer.text');
        $found = numberof($this->collection->count(), 'Найден', ['', 'о', 'о']);
        $text = $found . ' ' . $this->collection->count() . ' ' . numberof($this->collection->count(), $name, ['', 'а', 'ов']);
        return [
            'type'     => 'FeatureCollection',
            'found'    => $text,
            'features' => DealerResource::collection($this->collection),
        ];
    }
}