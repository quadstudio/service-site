<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Filters\Address\AddressOnlineStoreFilter;
use QuadStudio\Service\Site\Filters\Region\RegionDealerMapFilter;
use QuadStudio\Service\Site\Filters\Region\RegionMounterMapFilter;
use QuadStudio\Service\Site\Filters\Region\RegionServiceMapFilter;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;


class MapController extends Controller
{
    /**
     * @var RegionRepository
     */
    protected $regions;
    /**
     * @var AddressRepository
     */
    private $addresses;

    private $authorization_types;

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
        $this->authorization_types = AuthorizationType::query()
            ->where('brand_id', 1)
            ->where('enabled', 1)
            ->orderBy('name')
            ->get();
    }

    /**
     * Сервисные центры
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function service_centers(Request $request)
    {

        $selected_authorization_types = $request->input('filter.authorization_type', $this->authorization_types->pluck('id')->toArray());
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter(new RegionServiceMapFilter())
            ->all();
        $region_id = $request->input('filter.region_id');
        $authorization_types = $this->authorization_types;

        return view('site::map.service_center', compact(
            'regions',
            'region_id',
            'selected_authorization_types',
            'authorization_types'
        ));
    }

    /**
     * Где купить
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function where_to_buy(Request $request)
    {

        $selected_authorization_types = $request->input('filter.authorization_type', $this->authorization_types->pluck('id')->toArray());
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter(new RegionDealerMapFilter())
            ->all();
        $region_id = $request->input('filter.region_id');
        $authorization_types = $this->authorization_types;

        return view('site::map.where_to_buy', compact(
            'regions',
            'region_id',
            'selected_authorization_types',
            'authorization_types'
        ));

    }

    /**
     * Заявки на монтаж
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function mounter_requests(Request $request)
    {

        $selected_authorization_types = $request->input('filter.authorization_type', $this->authorization_types->pluck('id')->toArray());
        $regions = $this->regions
            ->trackFilter()
            ->applyFilter(new RegionMounterMapFilter())
            ->all();
        $region_id = $request->input('filter.region_id');
        $authorization_types = $this->authorization_types;

        return view('site::map.mounter_request', compact(
            'regions',
            'region_id',
            'selected_authorization_types',
            'authorization_types'
        ));

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

        return view('site::map.online_store', compact('addresses', 'roles'));
    }

}
