<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Filters\Address\CountrySelectFilter;
use QuadStudio\Service\Site\Filters\Address\IsServiceSelectFilter;
use QuadStudio\Service\Site\Filters\Address\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Address\SearchFilter;
use QuadStudio\Service\Site\Filters\Address\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\Address\UserFilter;
use QuadStudio\Service\Site\Filters\Address\IsShopSelectFilter;
use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\AddressRepository;

trait AddressControllerTrait
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->addresses->trackFilter();
        //$this->addresses->applyFilter((new AddressableFilter())->setId(Auth::user()->getAuthIdentifier())->setMorph('users'));
        $this->addresses->pushTrackFilter(CountrySelectFilter::class);
        $this->addresses->pushTrackFilter(RegionSelectFilter::class);
        $this->addresses->pushTrackFilter(TypeSelectFilter::class);
        $this->addresses->pushTrackFilter(SearchFilter::class);
        $this->addresses->pushTrackFilter(IsShopSelectFilter::class);
        $this->addresses->pushTrackFilter(IsServiceSelectFilter::class);
        $this->addresses->pushTrackFilter(UserFilter::class);
        return view('site::admin.address.index', [
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), ['addresses.*'])
        ]);
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $types = AddressType::find([$address->type_id,2,5]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id', $address->country_id)) {
            $regions = Region::where('country_id', old('country_id', $address->country_id))->orderBy('name')->get();
        }

        return view('site::admin.address.edit', compact('address', 'countries', 'regions', 'types'));
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
        $address->update($request->input(['address']));

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

    /**
     * @param PhoneRequest $request
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function phone(PhoneRequest $request, Address $address)
    {
        if ($request->isMethod('post')) {
            $address->phones()->save(Phone::create($request->except(['_token', '_method'])));

            return redirect()->route('admin.addresses.show', $address)->with('success', trans('site::phone.created'));
        } else {
            $countries = Country::enabled()->orderBy('sort_order')->get();

            return view('site::admin.address.phone', compact('countries', 'address'));
        }

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
