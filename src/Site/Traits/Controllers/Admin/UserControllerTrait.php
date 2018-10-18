<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Rbac\Repositories\RoleRepository;
use QuadStudio\Service\Site\Events\UserScheduleEvent;
use QuadStudio\Service\Site\Filters\PriceType\EnabledFilter;
use QuadStudio\Service\Site\Filters\User\ActiveSelectFilter;
use QuadStudio\Service\Site\Filters\User\AddressSearchFilter;
use QuadStudio\Service\Site\Filters\User\ContactSearchFilter;
use QuadStudio\Service\Site\Filters\User\DisplaySelectFilter;
use QuadStudio\Service\Site\Filters\User\IsAscSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsDealerSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsServiceFilter;
use QuadStudio\Service\Site\Filters\User\RegionFilter;
use QuadStudio\Service\Site\Filters\User\SortByCreatedAtFilter;
use QuadStudio\Service\Site\Filters\User\VerifiedFilter;
use QuadStudio\Service\Site\Filters\UserFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\UserRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\ContactRepository;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\OrderRepository;
use QuadStudio\Service\Site\Repositories\PriceTypeRepository;
use QuadStudio\Service\Site\Repositories\ProductTypeRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\UserPriceRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;
use QuadStudio\Service\Site\Repositories\WarehouseRepository;

trait UserControllerTrait
{
    /**
     * @var UserRepository
     */
    protected $users;
    /**
     * @var PriceTypeRepository
     */
    protected $price_types;
    /**
     * @var RoleRepository
     */
    protected $roles;
    /**
     * @var OrderRepository
     */
    protected $orders;
    /**
     * @var WarehouseRepository
     */
    protected $warehouses;
    /**
     * @var ContragentRepository
     */
    protected $contragents;
    /**
     * @var ContactRepository
     */
    protected $contacts;

    /**
     * @var RepairRepository
     */
    protected $repairs;
    /**
     * @var UserPriceRepository
     */
    private $user_prices;
    /**
     * @var ProductTypeRepository
     */
    private $product_types;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     * @param PriceTypeRepository $types
     * @param RoleRepository $roles
     * @param WarehouseRepository $warehouses
     * @param OrderRepository $orders
     * @param ContragentRepository $contragents
     * @param ContactRepository $contacts
     * @param RepairRepository $repairs
     * @param UserPriceRepository $user_prices
     * @param ProductTypeRepository $product_types
     */
    public function __construct(
        UserRepository $users,
        PriceTypeRepository $types,
        RoleRepository $roles,
        WarehouseRepository $warehouses,
        OrderRepository $orders,
        ContragentRepository $contragents,
        ContactRepository $contacts,
        RepairRepository $repairs,
        UserPriceRepository $user_prices,
        ProductTypeRepository $product_types
    )
    {
        $this->users = $users;
        $this->price_types = $types;
        $this->roles = $roles;
        $this->warehouses = $warehouses;
        $this->orders = $orders;
        $this->contragents = $contragents;
        $this->contacts = $contacts;
        $this->repairs = $repairs;
        $this->user_prices = $user_prices;
        $this->product_types = $product_types;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->users->trackFilter();
        $this->users->applyFilter(new SortByCreatedAtFilter());
        $this->users->applyFilter(new IsServiceFilter);
        $this->users->pushTrackFilter(ContactSearchFilter::class);
        $this->users->pushTrackFilter(RegionFilter::class);
        $this->users->pushTrackFilter(AddressSearchFilter::class);
        $this->users->pushTrackFilter(IsAscSelectFilter::class);
        $this->users->pushTrackFilter(IsDealerSelectFilter::class);
        $this->users->pushTrackFilter(ActiveSelectFilter::class);
        $this->users->pushTrackFilter(VerifiedFilter::class);
        $this->users->pushTrackFilter(DisplaySelectFilter::class);

        return view('site::admin.user.index', [
            'roles'      => $this->roles->all(),
            'repository' => $this->users,
            'users'      => $this->users->paginate(config('site.per_page.user', 10), ['users.*'])
        ]);
    }

    public function create()
    {
        $countries = Country::enabled()->orderBy('sort_order')->get();
        $address_sc_regions = collect([]);
        if (old('address.sc.country_id', false)) {
            $address_sc_regions = Region::where('country_id', old('address.sc.country_id'))->orderBy('name')->get();
        }
        $types = ContragentType::all();

        return view('site::admin.user.create', compact('countries', 'address_sc_regions', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        //dd($request->all());
        $user = $this->createUser($request->all());
        /** @var $sc Contact */
        if ($request->filled('sc')) {
            /** @var $sc Contact */
            $user->contacts()->save($sc = Contact::create($request->input('sc')));
            $sc->phones()->save(Phone::create($request->input('phone.sc')));
        }
        $user->addresses()->save(Address::create($request->input('address.sc')));
        $user->attachRole(4);

        return redirect()->route('admin.users.show', $user)->with('success', trans('site::user.created'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function createUser(array $data)
    {
        return User::create([

            'dealer'   => $data['dealer'],
            'active'   => $data['active'],
            'display'  => $data['display'],
            'verified' => $data['verified'],
            'name'     => $data['name'],
            'type_id'  => $data['type_id'],
            'email'    => $data['email'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $addresses = $user->addresses;
        $contacts = $user->contacts;
        $roles = $this->roles->all();

        return view('site::admin.user.show', compact('user', 'addresses', 'contacts', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = $this->roles->all();
        $warehouses = $this->warehouses->all();

        return view('site::admin.user.edit', compact('user', 'roles', 'warehouses'));
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schedule(User $user)
    {
        $this->authorize('schedule', $user);
        event(new UserScheduleEvent($user));

        return redirect()->route('admin.users.show', $user)->with('success', trans('site::schedule.created'));

    }

    /**
     * Обновить сервисный центр
     *
     * @param  UserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->input('user');

        if ($request->input('user.verified') == 1) {
            $data = array_merge($data, ['verify_token' => null]);
        }
        $user->update($data);
        $user->syncRoles($request->input('roles', []));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.users.edit', $user)->with('success', trans('site::user.updated'));
        } else {
            $redirect = redirect()->route('admin.users.show', $user)->with('success', trans('site::user.updated'));
        }

        return $redirect;
    }

    /**
     * Показать список контактов сервисного центра
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function repairs(User $user)
    {

        $this->repairs->trackFilter();
        $this->repairs->applyFilter((new UserFilter())->setUser($user));

        return view('site::admin.user.repair', [
            'user'       => $user,
            'repository' => $this->repairs,
            'repairs'    => $this->repairs->paginate(config('site.per_page.repair', 10), ['repairs.*'])
        ]);
    }

    /**
     * Ценообразование пользователя
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function prices(Request $request, User $user)
    {
        if ($request->isMethod('post')) {
            $user->prices()->delete();
            $data = [];
            foreach ($request->input('user_price') as $product_type_id => $price_type_id) {
                $data[] = [
                    'product_type_id' => $product_type_id,
                    'price_type_id'   => $price_type_id,
                ];
            }
            $user->prices()->createMany($data);
            if ($request->input('_stay') == 1) {
                $redirect = redirect()->route('admin.users.prices', $user)->with('success', trans('site::user_price.updated'));
            } else {
                $redirect = redirect()->route('admin.users.show', $user)->with('success', trans('site::user_price.updated'));
            }

            return $redirect;
        } else {
            $user_prices = $user->prices;
            $product_types = $this->product_types->all();
            $price_types = $this->price_types->applyFilter(new EnabledFilter())->all();
            $default_price_type = config('site.defaults.user.price_type_id');

            return view('site::admin.user.price', compact(
                'user',
                'user_prices',
                'product_types',
                'price_types',
                'default_price_type'
            ));
        }
    }

    /**
     * Показать список заказов сервисного центра
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function orders(User $user)
    {
        $this->orders->trackFilter();
        $this->orders->applyFilter((new UserFilter())->setUser($user));

        return view('site::admin.user.order', [
            'user'       => $user,
            'repository' => $this->orders,
            'orders'     => $this->orders->paginate(config('site.per_page.order', 10), ['orders.*'])
        ]);
    }

    /**
     * Показать список контрагентов сервисного центра
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function contragents(User $user)
    {

        $this->contragents->trackFilter();
        $this->contragents->applyFilter((new UserFilter())->setUser($user));

        return view('site::admin.user.contragent.index', [
            'user'        => $user,
            'repository'  => $this->contragents,
            'contragents' => $this->contragents->paginate(config('site.per_page.contragent', 10), ['contragents.*'])
        ]);
    }

    /**
     * Показать список контактов сервисного центра
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function contacts(User $user)
    {

        $this->contacts->trackFilter();
        $this->contacts->applyFilter((new UserFilter())->setUser($user));

        return view('site::admin.user.contact', [
            'user'       => $user,
            'repository' => $this->contacts,
            'contacts'   => $this->contacts->paginate(config('site.per_page.contact', 10), ['contacts.*'])
        ]);
    }

}