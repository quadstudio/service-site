<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        return [
//            'data' => $this->collection,
//            'links' => [
//                'self' => 'link-value',
//            ],
//        ];
        return parent::toArray($request);

//        return [
//            'data' => $this->collection,
//            'links' => [
//                'self' => 'link-value',
//            ],
//        ];
//        return [
//            'id' => $this->id,
//            'number' => $this->number,
//            'files' => ContragentResource::collection($this->files),
//        ];
    }
}