<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin\User;


use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
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
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->addresses->trackFilter();
        $this->addresses->applyFilter((new AddressableFilter())->setId($user->getKey())->setMorph($user->path()));

        return view('site::admin.user.address.index', [
            'user'       => $user,
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), ['addresses.*'])
        ]);
    }

    /**
     * @param User $user
	 * Для адресов пользователя доступны фактический, интернет-магазин, оптовый склад 2,5,6
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        $types = AddressType::find([2,5,6]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $regions = collect([]);
        if (old('country_id')) {
            $regions = Region::where('country_id', old('country_id'))->orderBy('name')->get();
        }

        return view('site::admin.user.address.create', compact('user', 'countries', 'regions', 'types'));
    }

    /**
     * @param AddressRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddressRequest $request, User $user)
    {
        /** @var $address Address */
        $user->addresses()->save($address = Address::create($request->input('address')));
        $address->phones()->create($request->input('phone'));

        return redirect()->route('admin.users.addresses.index', $user)->with('success', trans('site::address.created'));
    }

}
