<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Filters\Address\ActiveFilter;
use QuadStudio\Service\Site\Filters\Address\IsEShopFilter;
use QuadStudio\Service\Site\Filters\Address\TypeFilter;
use QuadStudio\Service\Site\Filters\Address\UserActiveFilter;
use QuadStudio\Service\Site\Filters\Address\UserDisplayFilter;
use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Filters\User\UserIsEShopFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;

trait AddressControllerTrait
{

    protected $addresses;
    /**
     * @var RegionRepository
     */
    private $regions;

    /**
     * Create a new controller instance.
     *
     * @param AddressRepository $addresses
     * @param RegionRepository $regions
     */
    public function __construct(
        AddressRepository $addresses,
        RegionRepository $regions
    )
    {
        $this->addresses = $addresses;
        $this->regions = $regions;
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
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), ['addresses.*'])
        ]);
    }

    public function create()
    {
        $types = AddressType::find([2,5]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id')) {
            $regions = Region::where('country_id', old('country_id'))->orderBy('name')->get();
        }

        return view('site::address.create', compact('countries', 'regions', 'types'));
    }

    public function store(AddressRequest $request)
    {
        /** @var $address Address */
        $request->user()->addresses()->save($address = Address::create($request->input('address')));
        $address->phones()->save(Phone::create($request->input('phone')));

        return redirect()->route('addresses.index')->with('success', trans('site::address.created'));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $this->authorize('edit', $address);
        if ($address->addressable_type == 'contragents') {
            $types = AddressType::find([1]);
        } else {
            $types = AddressType::find([2,2]);
        }

        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id', $address->country_id)) {
            $regions = Region::where('country_id', old('country_id', $address->country_id))->orderBy('name')->get();
        }

        return view('site::address.edit', compact('address', 'countries', 'regions', 'types'));
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

        return redirect()->route('addresses.show', $address)->with('success', trans('site::address.updated'));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        $this->authorize('view', $address);

        return view('site::address.show', compact('address'));
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

            return redirect()->route('addresses.show', $address)->with('success', trans('site::phone.created'));
        } else {
            $countries = Country::enabled()->orderBy('sort_order')->get();

            return view('site::address.phone', compact('countries', 'address'));
        }

    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->phones()->delete();
        if ($address->delete()) {
            $json['remove'][] = '#address-' . $address->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

    /**
     * Show the eshop's list
     *
     * @return \Illuminate\Http\Response
     */
    public function eshop()
    {

        $addresses = $this->addresses
            ->trackFilter()
            ->applyFilter((new TypeFilter())->setTypeId(5))
            ->applyFilter(new IsEShopFilter())
            ->applyFilter(new ActiveFilter())
            ->applyFilter(new UserDisplayFilter())
            ->applyFilter(new UserIsEShopFilter())
            ->applyFilter(new UserActiveFilter())
            ->all();
        $roles = Role::query()->where('display', 1)->get();

        return view('site::dealer.eshop', compact('addresses', 'roles'));
    }

}
