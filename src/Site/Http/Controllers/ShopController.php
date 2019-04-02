<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Filters\Address\AddressOnlineStoreFilter;
use QuadStudio\Service\Site\Filters\Address\AddressServiceCenterFilter;
use QuadStudio\Service\Site\Filters\Address\AddressWhereToBuyFilter;
use QuadStudio\Service\Site\Filters\Region\RegionsSelectedFilter;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;


class ShopController extends Controller
{
    /**
     * @var RegionRepository
     */
    protected $regions;
    /**
     * @var AddressRepository
     */
    private $addresses;

    /**
     * Create a new controller instance.
     *
     * @param RegionRepository $regions
     * @param AddressRepository $addresses
     */
    public function __construct(
        RegionRepository $regions,
        AddressRepository $addresses
    )
    {
        $this->regions = $regions;
        $this->addresses = $addresses;
    }

    /**
     * Где купить
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function where_to_buy(Request $request)
    {
        $this->addresses
            ->trackFilter()
            ->applyFilter(new AddressWhereToBuyFilter());
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter((new RegionsSelectedFilter())->setRegions($this->addresses->all()->pluck('region_id')->unique()->toArray()))
            ->all();
        $region_id = $request->input('filter.region_id');

        return view('site::shop.where_to_buy', compact('regions', 'region_id'));
    }

    /**
     * Интернет-магазины
     *
     * @return \Illuminate\Http\Response
     */
    public function online_stores()
    {

        $addresses = $this->addresses
            ->trackFilter()
            ->applyFilter(new AddressOnlineStoreFilter())
            ->all();
        $roles = Role::query()->where('display', 1)->get();

        return view('site::shop.online_store', compact('addresses', 'roles'));
    }

    /**
     * Сервисные центры
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function service_centers(Request $request)
    {

        $this->addresses
            ->trackFilter()
            ->applyFilter(new AddressServiceCenterFilter());
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter((new RegionsSelectedFilter())->setRegions($this->addresses->all()->pluck('region_id')->unique()->toArray()))
            ->all();
        $region_id = $request->input('filter.region_id');

        return view('site::shop.service_center', compact('regions', 'region_id'));
    }

}
