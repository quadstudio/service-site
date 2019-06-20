<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Events\ActExport;
use QuadStudio\Service\Site\Events\ActRepairCreateEvent;
use QuadStudio\Service\Site\Filters\Act\ActPerPageFilter;
use QuadStudio\Service\Site\Filters\Act\ActUserFilter;
use QuadStudio\Service\Site\Filters\User\HasApprovedRepairFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\ActRequest;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Models\ActDetail;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\ActRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;

class ActController extends Controller
{

    use AuthorizesRequests;
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
     * @param ActRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ActRequest $request)
    {

        $this->acts->trackFilter();
        $this->acts->pushTrackFilter(ActUserFilter::class);
        $this->acts->pushTrackFilter(ActPerPageFilter::class);

        return view('site::admin.act.index', [
            'repository' => $this->acts,
            'acts'       => $this->acts->paginate($request->input('filter.per_page', config('site.per_page.act', 10)), ['acts.*'])
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ActRequest $request)
    {

        foreach ($request->input('repair') as $user_id => $contragents) {
            /** @var User $user */
            $user = User::query()->find($user_id);
            $acts = collect([]);
            foreach ($contragents as $contragent_id => $repairs) {
                $contragent = Contragent::query()->find($contragent_id);
                /** @var Act $act */
                $user->acts()->save($act = Act::create([
                    'contragent_id' => $contragent_id,
                    'type_id'       => 1
                ]));

                $act->details()->saveMany([
                    new ActDetail($contragent->organization->toArray()),
                    new ActDetail($contragent->toArray())
                ]);
                foreach ($repairs as $repair_id) {
                    /** @var Repair $repair */
                    $repair = Repair::query()->find($repair_id);

                    $repair->act()->associate($act);

                    $repair->save();

                }
                $acts->push($act);
            }
            event(new ActRepairCreateEvent($user, $acts));
        }

        return redirect()->route('admin.acts.index')->with('success', trans('site::act.created'));
    }

    /**
     * @param Act $act
     * @return \Illuminate\Http\Response
     */
    public function edit(Act $act)
    {
        $this->authorize('update', $act);

        return view('site::admin.act.edit', compact('act'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ActRequest $request
     * @param  Act $act
     * @return \Illuminate\Http\Response
     */
    public function update(ActRequest $request, Act $act)
    {
        $act->update(array_merge($request->input(['act']), [
            'received' => $request->filled('act.received'),
            'paid'     => $request->filled('act.paid')
        ]));

        return redirect()->route('admin.acts.show', $act)->with('success', trans('site::act.updated'));
    }

    /**
     * @param Act $act
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schedule(Act $act)
    {
        $this->authorize('schedule', $act);
        event(new ActExport($act));

        return redirect()->route('admin.acts.show', $act)->with('success', trans('site::schedule.created'));

    }
}