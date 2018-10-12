<?php

namespace QuadStudio\Service\Site\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'countryName' => $this->countryName,
            'countryCode' => $this->countryCode,
            'regionCode' => $this->regionCode,
            'regionName' => $this->regionName,
            'cityName' => $this->cityName,
            'zipCode' => $this->zipCode,
            'isoCode' => $this->isoCode,
            'postalCode' => $this->postalCode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'metroCode' => $this->metroCode,
            'areaCode' => $this->areaCode,
        ];
    }
}