<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\RegionCollection;
use QuadStudio\Service\Site\Http\Resources\RegionResource;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\RegionRepository;

trait RegionControllerTrait
{
    protected $regions;

    /**
     * Create a new controller instance.
     *
     * @param RegionRepository $regions
     */
    public function __construct(RegionRepository $regions)
    {
        $this->regions = $regions;
    }

    /**
     * Show the region profile
     *
     * @param Country $country
     * @return RegionCollection
     */
    public function index(Country $country)
    {
        return new RegionCollection($country->regions()->orderBy('name')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param Region $region
     * @return RegionResource
     */
    public function show(Region $region)
    {
        return new RegionResource($region);
    }
}