<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use QuadStudio\Rbac\Repositories\RoleRepository;
use QuadStudio\Service\Site\Events\UserScheduleEvent;
use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Filters\User\ActiveFilter;
use QuadStudio\Service\Site\Filters\User\AddressSearchFilter;
use QuadStudio\Service\Site\Filters\User\ContactSearchFilter;
use QuadStudio\Service\Site\Filters\User\DisplayFilter;
use QuadStudio\Service\Site\Filters\User\IsAscFilter;
use QuadStudio\Service\Site\Filters\User\RegionFilter;
use QuadStudio\Service\Site\Filters\User\VerifiedFilter;
use QuadStudio\Service\Site\Filters\UserFilter;
use QuadStudio\Service\Site\Filters\UserIsServiceFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\UserRequest;
use QuadStudio\Service\Site\Mail\Admin\Order\OrderCreateEmail;
use QuadStudio\Service\Site\Mail\Admin\Repair\RepairCreateEmail;
use QuadStudio\Service\Site\Mail\Admin\Repair\RepairEditEmail;
use QuadStudio\Service\Site\Mail\Admin\User\UserRegisteredEmail;
use QuadStudio\Service\Site\Mail\User\UserConfirmationEmail;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\AddressRepository;
use QuadStudio\Service\Site\Repositories\ContactRepository;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\OrderRepository;
use QuadStudio\Service\Site\Repositories\PriceTypeRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;
use QuadStudio\Service\Site\Repositories\WarehouseRepository;

trait UserControllerTrait
{
    protected $users;
    protected $types;
    protected $roles;
    protected $orders;
    protected $warehouses;
    protected $contragents;
    protected $contacts;
    protected $addresses;
    protected $repairs;

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
     * @param AddressRepository $addresses
     * @param RepairRepository $repairs
     */
    public function __construct(
        UserRepository $users,
        PriceTypeRepository $types,
        RoleRepository $roles,
        WarehouseRepository $warehouses,
        OrderRepository $orders,
        ContragentRepository $contragents,
        ContactRepository $contacts,
        AddressRepository $addresses,
        RepairRepository $repairs
    )
    {
        $this->users = $users;
        $this->types = $types;
        $this->roles = $roles;
        $this->warehouses = $warehouses;
        $this->orders = $orders;
        $this->contragents = $contragents;
        $this->contacts = $contacts;
        $this->addresses = $addresses;
        $this->repairs = $repairs;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->users->trackFilter();
        $this->users->applyFilter(new UserIsServiceFilter);
        $this->users->pushTrackFilter(ContactSearchFilter::class);
        $this->users->pushTrackFilter(RegionFilter::class);
        $this->users->pushTrackFilter(AddressSearchFilter::class);
        $this->users->pushTrackFilter(IsAscFilter::class);
        $this->users->pushTrackFilter(ActiveFilter::class);
        $this->users->pushTrackFilter(VerifiedFilter::class);
        $this->users->pushTrackFilter(DisplayFilter::class);

        return view('site::admin.user.index', [
            'repository' => $this->users,
            'users'      => $this->users->paginate(config('site.per_page.user', 10), [env('DB_PREFIX', '') . 'users.*'])
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

        $address = $user->addresses()->where('type_id', 2)->firstOrNew([]);
        $contact = $user->contacts()->where('type_id', 1)->firstOrNew([]);
        $sc = $user->contacts()->where('type_id', 2)->firstOrNew([]);

        return view('site::admin.user.show', compact('user', 'address', 'contact', 'sc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $types = $this->types->all();
        $roles = $this->roles->all();
        $warehouses = $this->warehouses->all();

        return view('site::admin.user.edit', compact('user', 'types', 'roles', 'warehouses'));
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
        $this->users->update($request->input('user'), $user->id);
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
            'repairs'    => $this->repairs->paginate(config('site.per_page.repair', 10), [env('DB_PREFIX', '') . 'repairs.*'])
        ]);
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
            'orders'     => $this->orders->paginate(config('site.per_page.order', 10), [env('DB_PREFIX', '') . 'orders.*'])
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

        return view('site::admin.user.contragent', [
            'user'        => $user,
            'repository'  => $this->contragents,
            'contragents' => $this->contragents->paginate(config('site.per_page.contragent', 10), [env('DB_PREFIX', '') . 'contragents.*'])
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
            'contacts'   => $this->contacts->paginate(config('site.per_page.contact', 10), [env('DB_PREFIX', '') . 'contacts.*'])
        ]);
    }

    /**
     * Показать список адресов сервисного центра
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function addresses(User $user)
    {

        $this->addresses->trackFilter();
        $this->addresses->applyFilter((new AddressableFilter())->setId($user->id)->setMorph('users'));

        return view('site::admin.user.address', [
            'user'       => $user,
            'repository' => $this->addresses,
            'addresses'  => $this->addresses->paginate(config('site.per_page.address', 10), [env('DB_PREFIX', '') . 'addresses.*'])
        ]);
    }
}