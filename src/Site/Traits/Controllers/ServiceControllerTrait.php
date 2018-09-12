<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\Region\OnlyEnabledUserFilter;
use QuadStudio\Service\Site\Filters\Region\SelectFilter;
use QuadStudio\Service\Site\Models\Service;
use QuadStudio\Service\Site\Repositories\RegionRepository;
use QuadStudio\Service\Site\Repositories\ServiceRepository;

trait ServiceControllerTrait
{

    protected $services;
    protected $regions;

    /**
     * Create a new controller instance.
     *
     * @param ServiceRepository $services
     * @param RegionRepository $regions
     */
    public function __construct(ServiceRepository $services, RegionRepository $regions)
    {
        $this->services = $services;
        $this->regions = $regions;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->regions->trackFilter();
        $this->regions->applyFilter(new SelectFilter());
        $this->regions->applyFilter(new OnlyEnabledUserFilter());
        $regions = $this->regions->all(['regions.*']);

        return view('site::service.index', compact('regions'));
    }

    public function show(Service $service)
    {
        return view('site::service.show', ['service' => $service]);
    }
}