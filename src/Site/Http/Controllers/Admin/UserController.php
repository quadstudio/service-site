<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use QuadStudio\Rbac\Repositories\RoleRepository;
use QuadStudio\Service\Site\Events\UserScheduleEvent;
use QuadStudio\Service\Site\Exports\Excel\UserExcel;
use QuadStudio\Service\Site\Filters\District\SortFilter;
use QuadStudio\Service\Site\Filters\User\ActiveSelectFilter;
use QuadStudio\Service\Site\Filters\User\AddressSearchFilter;
use QuadStudio\Service\Site\Filters\User\ContactSearchFilter;
use QuadStudio\Service\Site\Filters\User\ContragentSearchFilter;
use QuadStudio\Service\Site\Filters\User\DisplaySelectFilter;
use QuadStudio\Service\Site\Filters\User\IsAscSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsCscSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsDealerSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsDistrSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsEshopSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsGendistrSelectFilter;
use QuadStudio\Service\Site\Filters\User\IsMontageSelectFilter;
use QuadStudio\Service\Site\Filters\User\RegionFilter;
use QuadStudio\Service\Site\Filters\User\UserNotAdminFilter;
use QuadStudio\Service\Site\Filters\User\UserRoleFilter;
use QuadStudio\Service\Site\Filters\User\UserSortFilter;
use QuadStudio\Service\Site\Filters\User\VerifiedFilter;
use QuadStudio\Service\Site\Filters\UserSearchFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\UserRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\DistrictRepository;
use QuadStudio\Service\Site\Repositories\TemplateRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;
use QuadStudio\Service\Site\Repositories\WarehouseRepository;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;

class UserController extends Controller
{

	use AuthorizesRequests;
	/**
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * @var RoleRepository
	 */
	protected $roles;

	/**
	 * @var WarehouseRepository
	 */
	protected $warehouses;

	/**
	 * @var TemplateRepository
	 */
	private $templates;
	/**
	 * @var DistrictRepository
	 */
	private $districts;


	/**
	 * Create a new controller instance.
	 *
	 * @param UserRepository $users
	 * @param RoleRepository $roles
	 * @param WarehouseRepository $warehouses
	 * @param TemplateRepository $templates
	 * @param DistrictRepository $districts
	 */
	public function __construct(
		UserRepository $users,
		RoleRepository $roles,
		WarehouseRepository $warehouses,
		TemplateRepository $templates,
		DistrictRepository $districts
	)
	{
		$this->users = $users;
		$this->roles = $roles;
		$this->warehouses = $warehouses;
		$this->templates = $templates;
		$this->districts = $districts;
	}

	/**
	 * Show the user profile
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	public function index(Request $request)
	{
		$this->users->trackFilter();
		$this->users->applyFilter(new UserNotAdminFilter);
		$this->users->pushTrackFilter(UserSearchFilter::class);
		$this->users->pushTrackFilter(ContactSearchFilter::class);
		$this->users->pushTrackFilter(ContragentSearchFilter::class);
		$this->users->pushTrackFilter(RegionFilter::class);
		$this->users->pushTrackFilter(AddressSearchFilter::class);
		$this->users->pushTrackFilter(IsMontageSelectFilter::class);
		$this->users->pushTrackFilter(IsAscSelectFilter::class);
		$this->users->pushTrackFilter(IsCscSelectFilter::class);
		$this->users->pushTrackFilter(IsDealerSelectFilter::class);
		$this->users->pushTrackFilter(IsDistrSelectFilter::class);
		$this->users->pushTrackFilter(IsGendistrSelectFilter::class);
		$this->users->pushTrackFilter(IsEshopSelectFilter::class);
		$this->users->pushTrackFilter(ActiveSelectFilter::class);
		$this->users->pushTrackFilter(VerifiedFilter::class);
		$this->users->pushTrackFilter(DisplaySelectFilter::class);
		$this->users->pushTrackFilter(UserSortFilter::class);
		$this->users->pushTrackFilter(UserRoleFilter::class);
		if ($request->has('excel')) {
			(new UserExcel())->setRepository($this->users)->render();
		}


		return view('site::admin.user.index', [
			'roles' => $this->roles->all(),
			'repository' => $this->users,
			'users' => $this->users->paginate(config('site.per_page.user', 10), ['users.*']),
		]);
	}

	public function create()
	{
		$countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();
		$regions = Region::query()->whereHas('country', function ($country) {
			$country->where('enabled', 1);
		})->orderBy('name')->get();
		$types = ContragentType::all();

		return view('site::admin.user.create', compact('countries', 'regions', 'types'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  UserRequest $request
	 *
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
		$user->addresses()->save($address = Address::create($request->input('address.sc')));
		$user->attachRole(4);

		return redirect()->route('admin.users.show', $user)->with('success', trans('site::user.created'));
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 *
	 * @return User
	 */
	protected function createUser(array $data)
	{
		return User::create([

			'region_id' => $data['address']['sc']['region_id'],
			'dealer' => $data['dealer'],
			'active' => $data['active'],
			'display' => $data['display'],
			'verified' => $data['verified'],
			'name' => $data['name'],
			'email' => $data['email'],
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{

		$addresses = $user->addresses()->get();
		$contacts = $user->contacts()->get();
		$roles = $this->roles->all();
		$authorization_accepts = $user->authorization_accepts()->get();
		$authorization_roles = AuthorizationRole::query()->get();
		$authorization_types = AuthorizationType::query()->where('enabled', 1)->get();

		return view('site::admin.user.show', compact(
			'user',
			'addresses',
			'contacts',
			'roles',
			'authorization_types',
			'authorization_roles',
			'authorization_accepts'
		));
	}

	public function digift(User $user)
	{

		if ($user->digiftUser()->doesntExist()) {
			$user->makeDigiftUser();
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$roles = $this->roles->all();
		$warehouses = $this->warehouses->all();
		$this->districts->applyFilter(new SortFilter());
		$districts = $this->districts->all();

		return view('site::admin.user.edit', compact('user', 'roles', 'warehouses', 'districts'));
	}


	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
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
	 *
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

		return redirect()->route('admin.users.show', $user)->with('success', trans('site::user.updated'));
	}

	/**
	 * Логин под пользователем
	 *
	 * @param User $user
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function force(User $user, Request $request)
	{

		Auth::guard()->logout();

		$request->session()->invalidate();

		Auth::login($user);

		return redirect()->route('home');

	}

}
