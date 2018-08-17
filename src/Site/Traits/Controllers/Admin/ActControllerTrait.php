<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\User\HasApprovedRepairFilter;
use QuadStudio\Service\Site\Http\Requests\ActRequest;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Repositories\ActRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;

trait ActControllerTrait
{
    /**
     * @var ActRepository
     */
    protected $acts;
    /**
     * @var RepairRepository
     */
    protected $repairs;
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Create a new controller instance.
     *
     * @param ActRepository $acts
     * @param RepairRepository $repairs
     * @param UserRepository $users
     */
    public function __construct(
        ActRepository $acts,
        RepairRepository $repairs,
        UserRepository $users
    )
    {
        $this->acts = $acts;
        $this->repairs = $repairs;
        $this->users = $users;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->acts->trackFilter();

        return view('site::admin.act.index', [
            'repository' => $this->acts,
            'acts'       => $this->acts->paginate(config('site.per_page.act', 10), [env('DB_PREFIX', '') . 'acts.*'])
        ]);
    }

    public function show(Act $act)
    {
        return view('site::admin.act.show', compact('act'));
    }

    public function create()
    {
        $repository = $this->repairs;
        $users = $this->users->applyFilter(new HasApprovedRepairFilter())->all();

        return view('site::admin.act.create', compact('repository', 'users'));
    }

    /**
     * @param ActRequest $request
     */
    public function store(ActRequest $request){
        dd('В РАЗРАБОТКЕ');
    }
}