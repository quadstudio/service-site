<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;


use Illuminate\Http\Request;
use QuadStudio\Service\Site\Filters\Event\SortCreatedAtFilter;
use QuadStudio\Service\Site\Filters\Member\DateFromFilter;
use QuadStudio\Service\Site\Filters\Member\DateToFilter;
use QuadStudio\Service\Site\Filters\Member\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Member\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Member\SearchFilter;
use QuadStudio\Service\Site\Filters\Member\SortSelectFilter;
use QuadStudio\Service\Site\Filters\Member\StatusSelectFilter;
use QuadStudio\Service\Site\Filters\Member\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\MemberStatus\MemberStatusSortAscFilter;
use QuadStudio\Service\Site\Filters\Region\SelectFilter;
use QuadStudio\Service\Site\Filters\Region\SortFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MemberRequest;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Repositories\MemberRepository;
use QuadStudio\Service\Site\Repositories\MemberStatusRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;

//
//

trait MemberControllerTrait
{
    /**
     * @var MemberRepository
     */
    protected $members;
    /**
     * @var RegionRepository
     */
    private $regions;
    /**
     * @var EventTypeRepository
     */
    private $types;
    /**
     * @var EventRepository
     */
    private $events;
    /**
     * @var MemberStatusRepository
     */
    private $statuses;

    /**
     * Create a new controller instance.
     *
     * @param MemberRepository $members
     * @param RegionRepository $regions
     * @param EventRepository $events
     * @param EventTypeRepository $types
     * @param MemberStatusRepository $statuses
     */
    public function __construct(
        MemberRepository $members,
        RegionRepository $regions,
        EventRepository $events,
        EventTypeRepository $types,
        MemberStatusRepository $statuses
    )
    {
        $this->members = $members;
        $this->regions = $regions;
        $this->types = $types;
        $this->events = $events;
        $this->statuses = $statuses;
    }

    /**
     * Show the members index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->members->trackFilter();
        $this->members->pushTrackFilter(SearchCityFilter::class);
        $this->members->pushTrackFilter(SearchFilter::class);
        $this->members->pushTrackFilter(StatusSelectFilter::class);
        $this->members->pushTrackFilter(TypeSelectFilter::class);
        $this->members->pushTrackFilter(RegionSelectFilter::class);
        $this->members->pushTrackFilter(DateFromFilter::class);
        $this->members->pushTrackFilter(DateToFilter::class);
        $this->members->pushTrackFilter(SortSelectFilter::class);

        return view('site::admin.member.index', [
            'repository' => $this->members,
            'members'    => $this->members->paginate(config('site.per_page.member', 10), ['members.*'])
        ]);
    }

    public function create(Request $request)
    {
        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $events = $this->events->applyFilter(new SortCreatedAtFilter())->all();
        $statuses = $this->statuses->applyFilter(new MemberStatusSortAscFilter())->all();
        $types = $this->types->all();
        $event = Event::query()->findOrNew($request->input('event_id'));

        return view('site::admin.member.create', compact('regions', 'types', 'event', 'events', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {

        $member = $this->members->create($request->except(['_method', '_token', '_create']));

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.participants.create', $member)->with('success', trans('site::member.created'));
        } else {
            $redirect = redirect()->route('admin.members.show', $member)->with('success', trans('site::member.created'));
        }

        return $redirect;
    }

    public function show(Member $member)
    {
        $member
            ->with('type')
            ->with('status')
            ->with('event')
            ->with('region');

        return view('site::admin.member.show', compact('member'));
    }

    public function edit(Member $member)
    {

        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $events = $this->events->applyFilter(new SortCreatedAtFilter())->all();
        $types = $this->types->all();
        $statuses = $this->statuses->applyFilter(new MemberStatusSortAscFilter())->all();


        return view('site::admin.member.edit', compact('member', 'types', 'regions', 'events', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MemberRequest $request
     * @param  Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, Member $member)
    {
        $data = $request->except(['_method', '_token', '_stay']);
        if ($request->input('verified') == 1) {
            $data['verify_token'] = null;
        }
        $member->update($data);
        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.members.edit', $member)->with('success', trans('site::member.updated'));
        } else {
            $redirect = redirect()->route('admin.members.show', $member)->with('success', trans('site::member.updated'));
        }

        return $redirect;
    }

    public function participants(Member $member)
    {
        return view('site::admin.member.participants', compact('member'));
    }


}