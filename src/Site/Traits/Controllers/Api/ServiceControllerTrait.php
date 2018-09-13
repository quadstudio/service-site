<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Filters\Address\ActiveFilter;
use QuadStudio\Service\Site\Filters\Address\RegionFilter;
use QuadStudio\Service\Site\Filters\Address\TypeFilter;
use QuadStudio\Service\Site\Filters\Address\UserActiveFilter;
use QuadStudio\Service\Site\Filters\Address\UserDisplayFilter;
use QuadStudio\Service\Site\Filters\Address\ShowAscDealerFilter;
use QuadStudio\Service\Site\Http\Resources\Address\YandexMapCollection;
use QuadStudio\Service\Site\Http\Resources\Address\YandexMapResource;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\AddressRepository;

trait ServiceControllerTrait
{
    protected $addresses;

    /**
     * Create a new controller instance.
     *
     * @param AddressRepository $addresses
     */
    public function __construct(AddressRepository $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * Show the country profile
     *
     * @param Region $region
     * @return YandexMapCollection
     */
    public function index(Request $request, Region $region)
    {
        return new YandexMapCollection(
            $this
                ->addresses
                ->trackFilter()
                ->applyFilter((new TypeFilter())->setTypeId(2))
                ->applyFilter((new RegionFilter())->setRegionId($region->id))
                ->applyFilter(new UserDisplayFilter())
                ->applyFilter(new UserActiveFilter())
                ->applyFilter(new ActiveFilter())
                ->pushTrackFilter(ShowAscDealerFilter::class)
                ->all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $service
     * @return YandexMapResource
     */
    public function show(User $service)
    {
        return new YandexMapResource($service);
    }
}