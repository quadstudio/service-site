<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Filters\User\ActiveFilter;
use QuadStudio\Service\Site\Filters\User\DisplayFilter;
use QuadStudio\Service\Site\Filters\Service\RegionFilter;
use QuadStudio\Service\Site\Filters\User\ShowAscDealerFilter;
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
    public function index(Request $request, Region $region)
    {

        //dd($request->all());
//        $this
//            ->services
//            ->trackFilter()
//            ->applyFilter(new ActiveFilter())
//            ->applyFilter(new DisplayFilter())
//            ->pushTrackFilter(IsAscSelectFilter::class)
//            ->pushTrackFilter(IsDealerSelectFilter::class)
//            ->applyFilter((new RegionFilter())->setRegion($region))
//            ->all();
//        dump($this->services->getBindings());
//        dd($this->services->toSql());
        return new ServiceCollection(
            $this
                ->services
                ->trackFilter()
                ->applyFilter(new ActiveFilter())
                ->applyFilter(new DisplayFilter())
                ->pushTrackFilter(ShowAscDealerFilter::class)
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