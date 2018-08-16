<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
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
        $this->authorize('index', Address::class);
        $this->addresses->trackFilter();
        $this->addresses->applyFilter((new AddressableFilter())->setId(Auth::user()->getAuthIdentifier())->setMorph('users'));

        return view('site::address.index', [
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), [env('DB_PREFIX', '') . 'addresses.*'])
        ]);
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $this->authorize('edit', $address);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id', $address->country_id)) {
            $regions = Region::where('country_id', old('country_id', $address->country_id))->orderBy('name')->get();
        }

        return view('site::address.edit', compact('address', 'countries', 'regions'));
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

        $this->addresses->update($request->except(['_token', '_method']), $address->id);
        return redirect()->route($address->addressable_type . '.index')->with('success', trans('site::address.updated'));
    }

}