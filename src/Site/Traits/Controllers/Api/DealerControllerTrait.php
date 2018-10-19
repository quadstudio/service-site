<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;


use QuadStudio\Service\Site\Filters\Address\ActiveFilter;
use QuadStudio\Service\Site\Filters\Address\IsShopFilter;
use QuadStudio\Service\Site\Filters\Address\RegionFilter;
use QuadStudio\Service\Site\Filters\Address\SortByNameFilter;
use QuadStudio\Service\Site\Filters\Address\SortByRegionFilter;
use QuadStudio\Service\Site\Filters\Address\SortByWeightFilter;
use QuadStudio\Service\Site\Filters\Address\TypeFilter;
use QuadStudio\Service\Site\Filters\Address\UserActiveFilter;
use QuadStudio\Service\Site\Filters\Address\UserDisplayFilter;
use QuadStudio\Service\Site\Http\Resources\Address\YandexMapCollection;
use QuadStudio\Service\Site\Http\Resources\Address\YandexMapResource;
use QuadStudio\Service\Site\Http\Resources\LocationResource;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use Stevebauman\Location\Facades\Location;

trait DealerControllerTrait
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
    public function index(Region $region)
    {
        return new YandexMapCollection(
            $this->addresses
                ->trackFilter()
                ->applyFilter((new TypeFilter())->setTypeId(2))
                ->applyFilter(new IsShopFilter())
                ->applyFilter(new ActiveFilter())
                ->applyFilter(new UserDisplayFilter())
                ->applyFilter(new UserActiveFilter())
                ->applyFilter((new RegionFilter())->setRegionId($region->id))
                ->applyFilter(new SortByRegionFilter())
                ->applyFilter(new SortByWeightFilter())
                ->applyFilter(new SortByNameFilter())
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

    public function location()
    {
        $ip = request()->ip();

        //$ip = '77.246.239.18';
        return new LocationResource(Location::get($ip));
    }
}