<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Address\AddressIsDealerFilter;
use QuadStudio\Service\Site\Filters\Address\AddressIsMounterFilter;
use QuadStudio\Service\Site\Filters\Address\AddressMapFilter;
use QuadStudio\Service\Site\Filters\Address\AddressIsServiceFilter;
use QuadStudio\Service\Site\Filters\Address\RegionFilter;
use QuadStudio\Service\Site\Http\Resources\Address\DealerCollection;
use QuadStudio\Service\Site\Http\Resources\Address\MounterCollection;
use QuadStudio\Service\Site\Http\Resources\Address\ServiceCollection;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\AddressRepository;

class MapController extends Controller
{

    private $addresses;

    private $authorization_types;

    /**
     * Create a new controller instance.
     *
     * @param AddressRepository $addresses
     */
    public function __construct(AddressRepository $addresses)
    {
        $this->addresses = $addresses;
        $this->authorization_types = AuthorizationType::query()
            ->where('brand_id', 1)
            ->where('enabled', 1)
            ->orderBy('name')
            ->get();
    }

    /**
     * @param Request $request
     * @param Region $region
     * @return ServiceCollection
     */
    public function service_centers(Request $request, Region $region)
    {

        return new ServiceCollection(
            $this->addresses
                ->trackFilter()
                ->applyFilter(new AddressIsServiceFilter())
                ->applyFilter(
                    (new AddressMapFilter())
                        ->setAccepts($request->input(
                            'filter.authorization_type',
                            $this->authorization_types->pluck('id')->toArray()
                        ))
                        ->setRoleId(3)
                )
                ->applyFilter((new RegionFilter())->setRegionId($region->id))
                ->all()
        );
    }

    /**
     * @param Request $request
     * @param Region $region
     * @return DealerCollection
     */
    public function where_to_buy(Request $request, Region $region)
    {

        return new DealerCollection(
            $this->addresses
                ->trackFilter()
                ->applyFilter(new AddressIsDealerFilter())
                ->applyFilter(
                    (new AddressMapFilter())
                        ->setAccepts($request->input(
                            'filter.authorization_type',
                            $this->authorization_types->pluck('id')->toArray()
                        ))
                        ->setRoleId(4)
                )
                ->applyFilter((new RegionFilter())->setRegionId($region->id))
                ->all()
        );
    }

    /**
     * @param Request $request
     * @param Region $region
     * @return MounterCollection
     */
    public function mounter_requests(Request $request, Region $region)
    {

        return new MounterCollection(
            $this->addresses
                ->trackFilter()
                ->applyFilter(new AddressIsMounterFilter())
                ->applyFilter(
                    (new AddressMapFilter())
                        ->setAccepts($request->input(
                            'filter.authorization_type',
                            $this->authorization_types->pluck('id')->toArray()
                        ))
                        ->setRoleId(11)
                )
                ->applyFilter((new RegionFilter())->setRegionId($region->id))
                ->all()
        );
    }

//    public function location()
//    {
//        $ip = request()->ip();
//
//        //$ip = '77.246.239.18';
//        return new LocationResource(Location::get($ip));
//    }
}