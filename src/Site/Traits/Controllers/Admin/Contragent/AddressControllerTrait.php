<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin\Contragent;


use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Repositories\AddressRepository;

trait AddressControllerTrait
{
    /**
     * @var AddressRepository
     */
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
     * Показать список адресов сервисного центра
     *
     * @param Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function index(Contragent $contragent)
    {
        $this->addresses->trackFilter();
        $this->addresses->applyFilter((new AddressableFilter())->setId($contragent->getKey())->setMorph($contragent->path()));

        return view('site::admin.contragent.address.index', [
            'contragent'       => $contragent,
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), [env('DB_PREFIX', '') . 'addresses.*'])
        ]);
    }

    /**
     * @param Contragent $contragent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Contragent $contragent)
    {
        $types = AddressType::find([2]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id')) {
            $regions = Region::where('country_id', old('country_id'))->orderBy('name')->get();
        }

        return view('site::admin.contragent.address.create', compact('contragent', 'countries', 'regions', 'types'));
    }

    /**
     * @param AddressRequest $request
     * @param Contragent $contragent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddressRequest $request, Contragent $contragent)
    {
        /** @var $address Address */
        $contragent->addresses()->save($address = Address::create($request->input('address')));
        $address->phones()->create($request->input('phone'));

        return redirect()->route('admin.contragents.addresses.index', $contragent)->with('success', trans('site::address.created'));
    }

}