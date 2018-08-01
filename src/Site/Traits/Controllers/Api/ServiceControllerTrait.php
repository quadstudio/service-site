<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\Service\DisplayFilter;
use QuadStudio\Service\Site\Filters\Service\RegionFilter;
use QuadStudio\Service\Site\Http\Resources\ServiceCollection;
use QuadStudio\Service\Site\Http\Resources\ServiceResource;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\UserRepository;

trait ServiceControllerTrait
{
    protected $services;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $services
     */
    public function __construct(UserRepository $services)
    {
        $this->services = $services;
    }

    /**
     * Show the country profile
     *
     * @param Region $region
     * @return ServiceCollection
     */
    public function index(Region $region)
    {
        return new ServiceCollection(
            $this
                ->services
                ->applyFilter(new DisplayFilter())
                ->applyFilter((new RegionFilter())->setRegion($region))
                ->all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $service
     * @return ServiceResource
     */
    public function show(User $service)
    {
        return new ServiceResource($service);
    }
}