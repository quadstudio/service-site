<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Http\Request;
use QuadStudio\Rbac\Repositories\RoleRepository;
use QuadStudio\Service\Site\Filters\Address\ActiveFilter;
use QuadStudio\Service\Site\Filters\Address\IsServiceFilter;
use QuadStudio\Service\Site\Filters\Address\IsShopFilter;
use QuadStudio\Service\Site\Filters\Address\TypeFilter;
use QuadStudio\Service\Site\Filters\Address\UserActiveFilter;
use QuadStudio\Service\Site\Filters\Address\UserDisplayFilter;
use QuadStudio\Service\Site\Filters\Region\RegionsSelectedFilter;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;

trait DealerControllerTrait
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
     * @var RoleRepository
     */
    private $roles;

    /**
     * Create a new controller instance.
     *
     * @param RegionRepository $regions
     * @param RoleRepository $roles
     * @param AddressRepository $addresses
     */
    public function __construct(
        RegionRepository $regions,
        RoleRepository $roles,
        AddressRepository $addresses
    )
    {
        $this->regions = $regions;
        $this->addresses = $addresses;
        $this->roles = $roles;
    }

    /**
     * Show the user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->addresses
            ->trackFilter()
            ->applyFilter((new TypeFilter())->setTypeId(2))
            ->applyFilter(new IsShopFilter())
            ->applyFilter(new ActiveFilter())
            ->applyFilter(new UserDisplayFilter())
            ->applyFilter(new UserActiveFilter())
        ;
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter((new RegionsSelectedFilter())->setRegions($this->addresses->all()->pluck('region_id')->unique()->toArray()))
            ->all();
        $region_id = $request->input('filter.region_id');
        return view('site::dealer.index', compact('regions', 'region_id'));
    }

}