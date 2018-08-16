<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BoilerCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return BoilerResource::collection($this->collection);
    }
}