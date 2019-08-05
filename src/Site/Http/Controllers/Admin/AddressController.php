<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Exports\Excel\AddressExcel;
use QuadStudio\Service\Site\Filters\Address\AddressPerPageFilter;
use QuadStudio\Service\Site\Filters\Address\AddressShowFerroliBoolFilter;
use QuadStudio\Service\Site\Filters\Address\AddressShowLamborghiniBoolFilter;
use QuadStudio\Service\Site\Filters\Address\AddressUserSelectFilter;
use QuadStudio\Service\Site\Filters\Address\CountrySelectFilter;
use QuadStudio\Service\Site\Filters\Address\IsEShopSelectFilter;
use QuadStudio\Service\Site\Filters\Address\IsMounterSelectFilter;
use QuadStudio\Service\Site\Filters\Address\IsServiceSelectFilter;
use QuadStudio\Service\Site\Filters\Address\IsShopSelectFilter;
use QuadStudio\Service\Site\Filters\Address\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Address\SearchFilter;
use QuadStudio\Service\Site\Filters\Address\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\Address\UserFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\ProductGroupType;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\AddressRepository;

class AddressController extends Controller
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
     * Show the user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->addresses->trackFilter();
        $this->addresses->pushTrackFilter(SearchFilter::class);
        $this->addresses->pushTrackFilter(AddressShowFerroliBoolFilter::class);
        $this->addresses->pushTrackFilter(AddressShowLamborghiniBoolFilter::class);
        $this->addresses->pushTrackFilter(CountrySelectFilter::class);
        $this->addresses->pushTrackFilter(RegionSelectFilter::class);
        $this->addresses->pushTrackFilter(TypeSelectFilter::class);
        $this->addresses->pushTrackFilter(IsShopSelectFilter::class);
        $this->addresses->pushTrackFilter(IsServiceSelectFilter::class);
        $this->addresses->pushTrackFilter(IsEShopSelectFilter::class);
        $this->addresses->pushTrackFilter(IsMounterSelectFilter::class);
        $this->addresses->pushTrackFilter(AddressUserSelectFilter::class);
        $this->addresses->pushTrackFilter(UserFilter::class);
        if ($request->has('excel')) {
            (new AddressExcel())->setRepository($this->addresses)->render();
        }
        $this->addresses->pushTrackFilter(AddressPerPageFilter::class);

        return view('site::admin.address.index', [
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate($request->input('filter.per_page', config('site.per_page.address', 10)), ['addresses.*'])
        ]);
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $address_types = AddressType::query()->find([$address->type_id, 2, 5]);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();
        $regions = Region::query()->whereIn('country_id', $countries->toArray())->orderBy('name')->get();
        $product_group_types = ProductGroupType::query()->get();

        return view('site::admin.address.edit', compact('address', 'countries', 'regions', 'address_types', 'product_group_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AddressRequest $request
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, Address $address)
    {

        $address->update(array_merge(
            $request->input(['address']),
            ['show_ferroli' => $request->filled('address.show_ferroli')],
            ['show_lamborghini' => $request->filled('address.show_lamborghini')],
            ['is_shop' => $request->filled('address.is_shop')],
            ['is_service' => $request->filled('address.is_service')],
            ['is_eshop' => $request->filled('address.is_eshop')],
            ['is_mounter' => $request->filled('address.is_mounter')]
        ));

        $address->product_group_types()->sync($request->input('product_group_types', []));

        return redirect()->route('admin.addresses.show', $address)->with('success', trans('site::address.updated'));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return view('site::admin.address.show', compact('address'));
    }

    public function destroy(Address $address)
    {
        $address->phones()->delete();
        if ($address->delete()) {
            $json['remove'][] = '#address-' . $address->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}
