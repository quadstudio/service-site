<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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

class ReportAscController extends Controller
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

        return view('site::admin.reports.asc.index', [
            'roles'      => $this->roles->all(),
            'repository' => $this->users,
            'users'      => $this->users->paginate(config('site.per_page.user', 10), ['users.*'])
        ]);
    }

    

}
