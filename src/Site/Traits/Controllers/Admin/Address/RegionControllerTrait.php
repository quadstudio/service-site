<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin\Address;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Filters\District\SortFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\AddressRegionRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Repositories\DistrictRepository;

trait RegionControllerTrait
{

    /**
     * @var DistrictRepository
     */
    private $districts;

    /**
     * Create a new controller instance.
     *
     * @param DistrictRepository $districts
     */
    public function __construct(DistrictRepository $districts)
    {
        $this->districts = $districts;
    }

    /**
     * Показать список адресов сервисного центра
     *
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function index(Address $address)
    {

        $this->districts->trackFilter();
        $this->districts->applyFilter(new SortFilter());

        return view('site::admin.address.region.index', [
            'address'   => $address,
            'districts' => $this->districts->all()
        ]);
    }

    /**
     * @param Request $request
     * @param Address $address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Address $address)
    {

        $address->syncRegions($request->input('regions', []));

        return redirect()->route('admin.addresses.show', $address)->with('success', trans('site::address.regions_updated'));
    }

}